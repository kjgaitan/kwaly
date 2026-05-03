@props(['messages'])

@php
    $messages = is_string($messages)
        ? [$messages]
        : (array) $messages;

    $messages = array_filter($messages, fn ($message) => $message !== null && $message !== '');
@endphp

@if (count($messages))
    <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 p-5 text-sm text-red-200">
        <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-red-200">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>Revisa los campos del formulario</span>
        </div>

        <ul class="list-disc space-y-2 pl-5">
            @foreach ($messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
