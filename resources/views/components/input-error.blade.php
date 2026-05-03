@props(['messages'])

@php
    $messages = is_string($messages)
        ? [$messages]
        : (array) $messages;

    $messages = array_filter($messages, fn ($message) => $message !== null && $message !== '');
@endphp

@if (count($messages))
    <ul {{ $attributes->merge(['class' => 'mt-2 text-xs text-red-400 space-y-1']) }}>
        @foreach ($messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
