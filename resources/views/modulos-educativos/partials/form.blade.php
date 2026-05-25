@php
$niveles = [
    'basico' => 'Básico',
    'intermedio' => 'Intermedio',
    'avanzado' => 'Avanzado',
];

$plantillasModulo = [
    'finanzas_basicas' => [
        'titulo' => 'Finanzas personales básicas',
        'descripcion' => 'Aprende los conceptos esenciales para controlar tu dinero: ingresos, gastos, ahorro y hábitos financieros saludables.',
        'nivel' => 'basico',
    ],
    'presupuestos' => [
        'titulo' => 'Presupuestos mensuales',
        'descripcion' => 'Aprende a organizar tus ingresos y gastos cada mes utilizando métodos sencillos como la regla 50/30/20.',
        'nivel' => 'basico',
    ],
    'ahorro_metas' => [
        'titulo' => 'Ahorro y metas financieras',
        'descripcion' => 'Aprende a definir objetivos financieros, crear un fondo de emergencia y ahorrar de forma constante.',
        'nivel' => 'intermedio',
    ],
    'facturas_pagos' => [
        'titulo' => 'Facturas y pagos',
        'descripcion' => 'Aprende a organizar tus facturas, controlar pagos recurrentes y evitar retrasos en tus vencimientos.',
        'nivel' => 'basico',
    ],
    'deudas_creditos' => [
        'titulo' => 'Deudas y créditos',
        'descripcion' => 'Comprende cómo funcionan las deudas, los intereses y las cuotas para evitar el sobreendeudamiento.',
        'nivel' => 'intermedio',
    ],
    'seguridad_financiera' => [
        'titulo' => 'Seguridad financiera',
        'descripcion' => 'Aprende a proteger tu dinero frente a fraudes, phishing y malas prácticas digitales.',
        'nivel' => 'basico',
    ],
];
@endphp

<div class="grid gap-5">
    <div>
        <label for="plantilla_modulo" class="mb-2 block text-sm font-medium text-gray-300">
            Plantilla del módulo
        </label>

        <select id="plantilla_modulo"
            class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white focus:border-green-500 focus:outline-none">
            <option value="">Seleccione una plantilla</option>

            @foreach($plantillasModulo as $clave => $plantilla)
            <option value="{{ $clave }}">{{ $plantilla['titulo'] }}</option>
            @endforeach

            <option value="personalizado">Personalizado</option>
        </select>

        <p class="mt-2 text-xs text-gray-500">
            La duración del módulo se calculará automáticamente sumando la duración de sus lecciones.
        </p>
    </div>

    <div>
        <label for="titulo" class="mb-2 block text-sm font-medium text-gray-300">Título</label>
        <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $modulo->titulo ?? '') }}" required
            class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white placeholder:text-gray-500 focus:border-green-500 focus:outline-none"
            placeholder="Ejemplo: Presupuestos mensuales">

        <x-input-error :messages="$errors->get('titulo')" />
    </div>

    <div>
        <label for="descripcion" class="mb-2 block text-sm font-medium text-gray-300">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4" required
            class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white placeholder:text-gray-500 focus:border-green-500 focus:outline-none"
            placeholder="Explica brevemente qué aprenderá el usuario en este módulo">{{ old('descripcion', $modulo->descripcion ?? '') }}</textarea>

        <x-input-error :messages="$errors->get('descripcion')" />
    </div>

    <div>
        <label for="nivel" class="mb-2 block text-sm font-medium text-gray-300">Nivel</label>
        <select id="nivel" name="nivel" required
            class="w-full rounded-xl border border-[#26352d] bg-[#111714] px-4 py-3 text-white focus:border-green-500 focus:outline-none">
            <option value="">Seleccione</option>

            @foreach($niveles as $valor => $texto)
            <option value="{{ $valor }}" {{ old('nivel', $modulo->nivel ?? '') === $valor ? 'selected' : '' }}>
                {{ $texto }}
            </option>
            @endforeach
        </select>

        <p class="mt-2 text-xs text-gray-500">
            La duración se define en cada lección. El módulo solo agrupa contenido por tema y dificultad.
        </p>

        <x-input-error :messages="$errors->get('nivel')" />
    </div>

    <div class="mt-8 flex items-center justify-end gap-3 pr-2 pb-2">
        <a href="{{ route('educacion.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-white/5 bg-white/[0.03] px-5 py-3 text-sm font-medium text-white transition hover:bg-white/[0.05]">
            <span>Cancelar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-green-500 px-5 py-3 text-sm font-semibold text-black transition hover:bg-green-400">
            <span>{{ $textoBoton }}</span>
        </button>
    </div>
</div>

<script>
const plantillasModulo = @json($plantillasModulo);

document.addEventListener('DOMContentLoaded', function() {
    const plantillaSelect = document.getElementById('plantilla_modulo');
    const tituloInput = document.getElementById('titulo');
    const descripcionTextarea = document.getElementById('descripcion');
    const nivelSelect = document.getElementById('nivel');

    plantillaSelect.addEventListener('change', function() {
        const clave = this.value;

        if (!plantillasModulo[clave]) {
            return;
        }

        const plantilla = plantillasModulo[clave];

        tituloInput.value = plantilla.titulo;
        descripcionTextarea.value = plantilla.descripcion;
        nivelSelect.value = plantilla.nivel;
    });
});
</script>
