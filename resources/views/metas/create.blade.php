<x-app-layout>
    <div class="min-h-screen bg-[#050807] px-4 py-6 text-white md:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-5xl metas-panel">
            <div class="px-5 py-6 md:px-7 lg:px-8">

                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white">
                            Nueva Meta Financiera
                        </h1>
                        <p class="mt-1 text-sm text-gray-400">
                            Define un nuevo objetivo de ahorro y empieza a seguir tu progreso.
                        </p>
                    </div>
                </div>


                <form action="{{ route('metas.store') }}" method="POST" class="space-y-6" novalidate>
                    @csrf

                    @include('metas.partials.form')

                    <div class="flex flex-col gap-3 border-t border-white/5 pt-5 sm:flex-row sm:justify-start">
                        <a href="{{ route('metas.index') }}" class="metas-btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="metas-btn-primary">
                            <i class="bi bi-check-lg"></i>
                            Guardar meta
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>