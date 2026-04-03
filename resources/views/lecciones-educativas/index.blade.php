<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#0b100d] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)] md:p-5 lg:p-6">

            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm text-green-400">Módulo</p>
                    <h1 class="text-2xl font-bold tracking-tight text-white md:text-3xl">
                        {{ $modulo->titulo }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-400">
                        Gestiona las lecciones asociadas a este módulo.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('modulos-educativos.index') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/5 bg-white/[0.03] px-4 py-3 text-sm font-medium text-white transition hover:bg-white/[0.05]">
                        <i class="bi bi-arrow-left"></i>
                        <span>Volver a módulos</span>
                    </a>

                    <a href="{{ route('modulos-educativos.lecciones.create', $modulo) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
                        <i class="bi bi-plus-lg"></i>
                        <span>Nueva lección</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if($lecciones->isEmpty())
                <div class="rounded-[20px] border border-[#26352d] bg-[#0d1310] p-8 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500/10 text-green-400">
                        <i class="bi bi-collection-play text-2xl"></i>
                    </div>

                    <h2 class="mt-4 text-lg font-semibold text-white">No hay lecciones registradas</h2>
                    <p class="mt-2 text-sm text-gray-400">
                        Crea la primera lección de este módulo.
                    </p>
                </div>
            @else
                <div class="overflow-hidden rounded-[20px] border border-[#26352d]">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead class="bg-white/[0.03]">
                                <tr>
                                    <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Título</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Duración</th>
                                    <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Contenido</th>
                                    <th class="px-4 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/5 bg-[#0d1310]">
                                @foreach($lecciones as $leccion)
                                    <tr class="transition hover:bg-white/[0.02]">
                                        <td class="px-4 py-4 align-top">
                                            <p class="font-medium text-white">{{ $leccion->titulo }}</p>
                                        </td>

                                        <td class="px-4 py-4 align-top text-sm text-gray-300">
                                            {{ $leccion->duracion_minutos }} min
                                        </td>

                                        <td class="px-4 py-4 align-top">
                                            <p class="max-w-xl text-sm text-gray-400">
                                                {{ \Illuminate\Support\Str::limit($leccion->contenido, 130) }}
                                            </p>
                                        </td>

                                        <td class="px-4 py-4 align-top">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('modulos-educativos.lecciones.edit', [$modulo, $leccion]) }}"
                                                   class="inline-flex items-center gap-2 rounded-lg border border-white/5 bg-white/[0.03] px-3 py-2 text-sm text-white transition hover:border-green-500/20 hover:bg-white/[0.05]">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Editar</span>
                                                </a>

                                                <form action="{{ route('modulos-educativos.lecciones.destroy', [$modulo, $leccion]) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta lección?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="inline-flex items-center gap-2 rounded-lg border border-red-500/20 bg-red-500/10 px-3 py-2 text-sm text-red-400 transition hover:bg-red-500/20">
                                                        <i class="bi bi-trash3"></i>
                                                        <span>Eliminar</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>