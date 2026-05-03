@php
    $success = session('success');
    $error = session('error');
    $warning = session('warning');
    $info = session('info');
    $status = session('status');
    $statusMessage = null;

    if ($status) {
        if ($status === 'verification-link-sent') {
            $statusMessage = __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.');
        } elseif ($status === 'profile-updated' || $status === 'password-updated') {
            $statusMessage = __('Saved.');
        } elseif (is_string($status)) {
            $statusMessage = $status;
        }
    }
@endphp

@if ($success)
    <x-alert type="success" :messages="$success" />
@endif

@if ($error)
    <x-alert type="error" :messages="$error" />
@endif

@if ($warning)
    <x-alert type="warning" :messages="$warning" />
@endif

@if ($info)
    <x-alert type="info" :messages="$info" />
@endif

@if ($statusMessage)
    <x-alert type="success" :messages="$statusMessage" />
@endif
