@props(['status'])

@if ($status)
    <x-alert type="success" :messages="$status" {{ $attributes }} />
@endif
