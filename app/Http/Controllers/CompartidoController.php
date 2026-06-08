<?php

namespace App\Http\Controllers;

use App\Http\Requests\Compartido\StoreGastoCompartidoRequest;
use App\Http\Requests\Compartido\StoreGrupoCompartidoRequest;
use App\Http\Requests\Compartido\StoreMiembroGrupoRequest;
use App\Http\Requests\Compartido\UpdateGastoCompartidoRequest;
use App\Http\Requests\Compartido\UpdateGrupoCompartidoRequest;
use App\Http\Requests\Compartido\UpdateMiembroGrupoRequest;
use App\Models\Categoria;
use App\Models\GastoCompartido;
use App\Models\GastoCompartidoParticipante;
use App\Models\GrupoCompartido;
use App\Models\GrupoMiembro;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompartidoController extends Controller
{
    /**
     * Muestra la pantalla principal del módulo compartido.
     */
    public function index(): View
    {
        $usuario = Auth::user();

        $grupoMiembro = GrupoMiembro::with(['grupo.miembros.usuario'])
            ->where('id_usuario', $usuario->id_usuario)
            ->first();

        $grupo = null;
        $grupoMiembroActual = null;
        $miembrosResumen = collect();
        $gastos = collect();
        $esAdminGrupo = false;
        $puedeRegistrarGasto = false;
        $usuariosDisponibles = collect();

        $resumen = [
            'total_aportado' => 0,
            'total_gastado' => 0,
            'balance_general' => 0,
            'numero_miembros' => 0,
        ];

        if ($grupoMiembro) {
            $grupoMiembroActual = $grupoMiembro;
            $esAdminGrupo = $grupoMiembro->rol === 'admin';
            $puedeRegistrarGasto = true;

            $grupo = GrupoCompartido::with([
                'miembros.usuario',
                'gastos.pagador',
                'gastos.categoriaRelacion',
                'gastos.participantes.usuario',
            ])->find($grupoMiembro->id_grupo);

            if ($grupo) {
                $gastos = $grupo->gastos
                    ->sortByDesc('fecha_gasto')
                    ->values();

                $miembros = $grupo->miembros;
                $totalGastado = $gastos->sum('monto_total');

                $miembrosResumen = $miembros->map(function ($miembro) use ($gastos) {
                    $aportado = $gastos
                        ->where('id_usuario_pagador', $miembro->id_usuario)
                        ->sum('monto_total');

                    $gastado = $gastos->sum(function ($gasto) use ($miembro) {
                        $participantes = $gasto->participantes;
                        $numeroParticipantes = $participantes->count();

                        if ($numeroParticipantes === 0) {
                            return 0;
                        }

                        return $participantes->contains('id_usuario', $miembro->id_usuario)
                            ? $gasto->monto_total / $numeroParticipantes
                            : 0;
                    });

                    $balance = $aportado - $gastado;

                    return [
                        'id_miembro' => $miembro->id_miembro,
                        'id_usuario' => $miembro->id_usuario,
                        'nombre' => $miembro->usuario?->nombre ?? 'Sin nombre',
                        'email' => $miembro->usuario?->email ?? '',
                        'rol' => $miembro->rol,
                        'aportado' => $aportado,
                        'gastado' => $gastado,
                        'balance' => $balance,
                    ];
                })->values();

                $resumen = [
                    'total_aportado' => $miembrosResumen->sum('aportado'),
                    'total_gastado' => $totalGastado,
                    'balance_general' => $miembrosResumen->sum('balance'),
                    'numero_miembros' => $miembros->count(),
                ];

                if ($esAdminGrupo) {
                    $usuariosDisponibles = Usuario::query()
                        ->whereNotIn('id_usuario', $miembros->pluck('id_usuario'))
                        ->where('estado_cuenta', 'activo')
                        ->orderBy('nombre')
                        ->get();
                }
            }
        }

        return view('compartido.index', compact(
            'grupo',
            'grupoMiembroActual',
            'miembrosResumen',
            'gastos',
            'resumen',
            'esAdminGrupo',
            'puedeRegistrarGasto',
            'usuariosDisponibles'
        ));
    }

    /**
     * Muestra el formulario dedicado para registrar un gasto compartido.
     */
    public function createGasto(): View|RedirectResponse
    {
        $usuario = Auth::user();

        $grupoMiembro = GrupoMiembro::with(['grupo.miembros.usuario'])
            ->where('id_usuario', $usuario->id_usuario)
            ->first();

        if (!$grupoMiembro || !$grupoMiembro->grupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Necesitas pertenecer a un grupo para registrar gastos.');
        }

        return view('compartido.gastos.create', [
            'grupo' => $grupoMiembro->grupo,
            'miembros' => $grupoMiembro->grupo->miembros,
            'categorias' => $this->obtenerCategoriasDisponibles($usuario->id_usuario),
        ]);
    }

    /**
     * Crea un grupo compartido y añade al usuario autenticado como administrador.
     */
    public function storeGrupo(StoreGrupoCompartidoRequest $request): RedirectResponse
    {
        $usuario = Auth::user();

        $yaTieneGrupo = GrupoMiembro::where('id_usuario', $usuario->id_usuario)->exists();

        if ($yaTieneGrupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Ya perteneces a un grupo compartido.');
        }

        $grupo = GrupoCompartido::create([
            'nombre_grupo' => $request->validated('nombre_grupo'),
            'descripcion' => $request->validated('descripcion'),
            'creado_por' => $usuario->id_usuario,
            'fecha_creacion' => now(),
        ]);

        GrupoMiembro::create([
            'id_grupo' => $grupo->id_grupo,
            'id_usuario' => $usuario->id_usuario,
            'rol' => 'admin',
            'fecha_union' => now(),
        ]);

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Grupo compartido creado correctamente.');
    }

    /**
     * Actualiza los datos básicos de un grupo compartido.
     */
    public function updateGrupo(UpdateGrupoCompartidoRequest $request, int $id): RedirectResponse
    {
        $grupo = GrupoCompartido::findOrFail($id);
        $usuario = Auth::user();

        $esAdmin = GrupoMiembro::where('id_grupo', $grupo->id_grupo)
            ->where('id_usuario', $usuario->id_usuario)
            ->where('rol', 'admin')
            ->exists();

        if (!$esAdmin) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No tienes permisos para editar este grupo.');
        }

        $grupo->update([
            'nombre_grupo' => $request->validated('nombre_grupo'),
            'descripcion' => $request->validated('descripcion'),
        ]);

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Grupo actualizado correctamente.');
    }

    /**
     * Añade un usuario existente al grupo mediante su email.
     */
    public function storeMiembro(StoreMiembroGrupoRequest $request): RedirectResponse
    {
        $usuarioActual = Auth::user();
        $idGrupo = $request->validated('id_grupo');

        $esAdmin = GrupoMiembro::where('id_grupo', $idGrupo)
            ->where('id_usuario', $usuarioActual->id_usuario)
            ->where('rol', 'admin')
            ->exists();

        if (!$esAdmin) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No tienes permisos para agregar miembros.');
        }

        $usuarioInvitado = Usuario::where('id_usuario', $request->validated('id_usuario'))
            ->where('estado_cuenta', 'activo')
            ->first();

        if (!$usuarioInvitado) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Selecciona un usuario valido para anadirlo al grupo.');
        }

        $yaPerteneceAlGrupo = GrupoMiembro::where('id_grupo', $idGrupo)
            ->where('id_usuario', $usuarioInvitado->id_usuario)
            ->exists();

        if ($yaPerteneceAlGrupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Este usuario ya forma parte de la cuenta compartida.');
        }

        $usuarioYaTieneGrupo = GrupoMiembro::where('id_usuario', $usuarioInvitado->id_usuario)->exists();

        if ($usuarioYaTieneGrupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Ese usuario ya pertenece a otro grupo.');
        }

        GrupoMiembro::create([
            'id_grupo' => $idGrupo,
            'id_usuario' => $usuarioInvitado->id_usuario,
            'rol' => 'miembro',
            'fecha_union' => now(),
        ]);

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Miembro agregado correctamente.');
    }

    /**
     * Elimina un miembro del grupo si el usuario actual es administrador.
     */
    public function destroyMiembro(int $id): RedirectResponse
    {
        $miembro = GrupoMiembro::findOrFail($id);
        $usuarioActual = Auth::user();

        $esAdmin = GrupoMiembro::where('id_grupo', $miembro->id_grupo)
            ->where('id_usuario', $usuarioActual->id_usuario)
            ->where('rol', 'admin')
            ->exists();

        if (!$esAdmin) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No tienes permisos para eliminar miembros.');
        }

        if ((int) $miembro->id_usuario === (int) $usuarioActual->id_usuario) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No puedes eliminarte a ti mismo desde aqui.');
        }

        DB::transaction(function () use ($miembro) {
            GastoCompartidoParticipante::where('id_usuario', $miembro->id_usuario)
                ->whereIn('id_gasto', GastoCompartido::where('id_grupo', $miembro->id_grupo)->select('id_gasto'))
                ->delete();

            $miembro->delete();
        });

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Miembro eliminado correctamente.');
    }

    /**
     * Actualiza un miembro del grupo.
     */
    public function updateMiembro(UpdateMiembroGrupoRequest $request, int $id): RedirectResponse
    {
        $miembro = GrupoMiembro::findOrFail($id);
        $usuarioActual = Auth::user();

        $esAdmin = GrupoMiembro::where('id_grupo', $miembro->id_grupo)
            ->where('id_usuario', $usuarioActual->id_usuario)
            ->where('rol', 'admin')
            ->exists();

        if (!$esAdmin) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No tienes permisos para editar miembros.');
        }

        $usuarioInvitado = Usuario::where('email', $request->validated('email'))->first();

        if (!$usuarioInvitado) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No existe ningún usuario con ese correo.');
        }

        $perteneceAMismoGrupo = GrupoMiembro::where('id_grupo', $request->validated('id_grupo'))
            ->where('id_usuario', $usuarioInvitado->id_usuario)
            ->where('id_miembro', '!=', $miembro->id_miembro)
            ->exists();

        if ($perteneceAMismoGrupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Ese usuario ya pertenece al grupo.');
        }

        $usuarioPerteneceAOtroGrupo = GrupoMiembro::where('id_usuario', $usuarioInvitado->id_usuario)
            ->where('id_miembro', '!=', $miembro->id_miembro)
            ->where('id_grupo', '!=', $miembro->id_grupo)
            ->exists();

        if ($usuarioPerteneceAOtroGrupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Ese usuario ya pertenece a otro grupo.');
        }

        $miembro->update([
            'id_grupo' => $request->validated('id_grupo'),
            'id_usuario' => $usuarioInvitado->id_usuario,
            'rol' => $request->validated('rol'),
        ]);

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Miembro actualizado correctamente.');
    }

    /**
     * Registra un nuevo gasto compartido en el grupo.
     */
    public function storeGasto(StoreGastoCompartidoRequest $request): RedirectResponse
    {
        $usuario = Auth::user();
        $idGrupo = $request->validated('id_grupo');

        $perteneceAlGrupo = GrupoMiembro::where('id_grupo', $idGrupo)
            ->where('id_usuario', $usuario->id_usuario)
            ->exists();

        if (!$perteneceAlGrupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No perteneces a este grupo.');
        }

        $pagadorPerteneceAlGrupo = GrupoMiembro::where('id_grupo', $idGrupo)
            ->where('id_usuario', $request->validated('id_usuario_pagador'))
            ->exists();

        if (!$pagadorPerteneceAlGrupo) {
            return redirect()
                ->route('compartido.gastos.create')
                ->withInput()
                ->with('error', 'El pagador seleccionado no pertenece a este grupo.');
        }

        DB::transaction(function () use ($request, $idGrupo) {
            $gasto = GastoCompartido::create([
                'id_grupo' => $idGrupo,
                'id_usuario_pagador' => $request->validated('id_usuario_pagador'),
                'titulo' => $request->validated('titulo'),
                'id_categoria' => $request->validated('id_categoria'),
                'descripcion' => $request->validated('descripcion'),
                'monto_total' => $request->validated('monto_total'),
                'fecha_gasto' => $request->validated('fecha_gasto'),
            ]);

            foreach ($request->validated('id_usuarios_participantes') as $idUsuario) {
                GastoCompartidoParticipante::create([
                    'id_gasto' => $gasto->id_gasto,
                    'id_usuario' => $idUsuario,
                ]);
            }
        });

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Gasto compartido registrado correctamente.');
    }

    /**
     * Actualiza un gasto compartido existente.
     */
    public function updateGasto(UpdateGastoCompartidoRequest $request, int $id): RedirectResponse
    {
        $gasto = GastoCompartido::findOrFail($id);
        $usuario = Auth::user();

        $perteneceAlGrupo = GrupoMiembro::where('id_grupo', $gasto->id_grupo)
            ->where('id_usuario', $usuario->id_usuario)
            ->exists();

        if (!$perteneceAlGrupo) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No tienes permisos para editar este gasto.');
        }

        $gasto->update([
            'id_grupo' => $request->validated('id_grupo'),
            'id_usuario_pagador' => $request->validated('id_usuario_pagador'),
            'titulo' => $request->validated('titulo'),
            'id_categoria' => $request->validated('id_categoria'),
            'descripcion' => $request->validated('descripcion'),
            'monto_total' => $request->validated('monto_total'),
            'fecha_gasto' => $request->validated('fecha_gasto'),
        ]);

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Gasto actualizado correctamente.');
    }

    private function obtenerCategoriasDisponibles(int $idUsuario)
    {
        return Categoria::where(function ($query) use ($idUsuario) {
            $query->where('id_usuario', $idUsuario)
                ->orWhereNull('id_usuario');
        })
            ->orderByRaw('id_usuario IS NULL DESC')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Elimina un gasto compartido si el usuario es admin del grupo o fue quien pago.
     */
    public function destroyGasto(int $id): RedirectResponse
    {
        $gasto = GastoCompartido::findOrFail($id);
        $usuario = Auth::user();

        $miembro = GrupoMiembro::where('id_grupo', $gasto->id_grupo)
            ->where('id_usuario', $usuario->id_usuario)
            ->first();

        if (!$miembro) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'No tienes permisos para eliminar este gasto.');
        }

        $puedeEliminar = $miembro->rol === 'admin'
            || (int) $gasto->id_usuario_pagador === (int) $usuario->id_usuario;

        if (!$puedeEliminar) {
            return redirect()
                ->route('compartido.index')
                ->with('error', 'Solo el administrador o quien pago el gasto puede eliminarlo.');
        }

        $gasto->delete();

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Gasto compartido eliminado correctamente.');
    }
}
