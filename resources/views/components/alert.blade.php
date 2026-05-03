@props(['type' => 'info', 'messages' => []])

@php
    $messages = is_string($messages)
        ? [$messages]
        : (array) $messages;

    $messages = array_filter($messages, fn ($message) => $message !== null && $message !== '');

    $types = [
        'success' => [
            'title' => 'Éxito',
            'icon' => 'bi-check-circle-fill',
            'classes' => 'border-emerald-500/20 bg-emerald-500/10 text-emerald-200',
        ],
        'error' => [
            'title' => 'Error',
            'icon' => 'bi-exclamation-octagon-fill',
            'classes' => 'border-red-500/30 bg-red-500/10 text-red-200',
        ],
        'warning' => [
            'title' => 'Atención',
            'icon' => 'bi-exclamation-triangle-fill',
            'classes' => 'border-amber-500/20 bg-amber-500/10 text-amber-200',
        ],
        'info' => [
            'title' => 'Info',
            'icon' => 'bi-info-circle-fill',
            'classes' => 'border-sky-500/20 bg-sky-500/10 text-sky-200',
        ],
    ];

    $config = $types[$type] ?? $types['info'];
@endphp

@if (count($messages))
    <div {{ $attributes->merge(['class' => "mb-6 rounded-2xl border p-5 text-sm {$config['classes']}"]) }}>
        <div class="mb-3 flex items-center gap-2 text-sm font-semibold">
            <i class="bi {{ $config['icon'] }}"></i>
            <span>{{ $config['title'] }}</span>
        </div>

        @if (count($messages) > 1)
            <ul class="list-disc space-y-2 pl-5">
                @foreach ($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @else
            <p>{{ $messages[0] }}</p>
        @endif
    </div>
@endif
