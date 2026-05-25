<?php

namespace App\Http\Controllers;

use App\Http\Requests\Compartido\StoreGastoCompartidoRequest;
use App\Http\Requests\Compartido\StoreGrupoCompartidoRequest;
use App\Http\Requests\Compartido\StoreMiembroGrupoRequest;
use App\Http\Requests\Compartido\UpdateGastoCompartidoRequest;
use App\Http\Requests\Compartido\UpdateGrupoCompartidoRequest;
use App\Http\Requests\Compartido\UpdateMiembroGrupoRequest;
use App\Models\GastoCompartido;
use App\Models\GrupoCompartido;
use App\Models\GrupoMiembro;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
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
            ])->find($grupoMiembro->id_grupo);

            if ($grupo) {
                $gastos = $grupo->gastos
                    ->sortByDesc('fecha_gasto')
                    ->values();

                $miembros = $grupo->miembros;
                $numeroMiembros = $miembros->count();

                $totalGastado = $gastos->sum('monto_total');
                $partePorPersona = $numeroMiembros > 0 ? $totalGastado / $numeroMiembros : 0;

                $miembrosResumen = $miembros->map(function ($miembro) use ($gastos, $partePorPersona) {
                    $aportado = $gastos
                        ->where('id_usuario_pagador', $miembro->id_usuario)
                        ->sum('monto_total');

                    $balance = $aportado - $partePorPersona;

                    return [
                        'id_miembro' => $miembro->id_miembro,
                        'id_usuario' => $miembro->id_usuario,
                        'nombre' => $miembro->usuario?->nombre ?? 'Sin nombre',
                        'email' => $miembro->usuario?->email ?? '',
                        'rol' => $miembro->rol,
                        'aportado' => $aportado,
                        'gastado' => $partePorPersona,
                        'balance' => $balance,
                    ];
                })->values();

                $resumen = [
                    'total_aportado' => $miembrosResumen->sum('aportado'),
                    'total_gastado' => $totalGastado,
                    'balance_general' => $miembrosResumen->sum('balance'),
                    'numero_miembros' => $numeroMiembros,
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
            'rol' => $request->validated('rol'),
            'fecha_union' => now(),
        ]);

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Miembro agregado correctamente.');
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

        GastoCompartido::create([
            'id_grupo' => $idGrupo,
            'id_usuario_pagador' => $request->validated('id_usuario_pagador'),
            'titulo' => $request->validated('titulo'),
            'categoria' => $request->validated('categoria'),
            'descripcion' => $request->validated('descripcion'),
            'monto_total' => $request->validated('monto_total'),
            'fecha_gasto' => $request->validated('fecha_gasto'),
        ]);

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
            'categoria' => $request->validated('categoria'),
            'descripcion' => $request->validated('descripcion'),
            'monto_total' => $request->validated('monto_total'),
            'fecha_gasto' => $request->validated('fecha_gasto'),
        ]);

        return redirect()
            ->route('compartido.index')
            ->with('success', 'Gasto actualizado correctamente.');
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
