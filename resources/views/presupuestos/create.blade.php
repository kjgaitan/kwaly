@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar categoría al presupuesto</h1>

    @if (session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('presupuestos.sobres.store', $presupuesto) }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="id_categoria">Categoría</label>
            <select name="id_categoria" id="id_categoria">
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="limite_monto">Límite de monto</label>
            <input type="number" step="0.01" name="limite_monto" id="limite_monto" value="{{ old('limite_monto') }}">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="monto_gastado">Monto gastado</label>
            <input type="number" step="0.01" name="monto_gastado" id="monto_gastado" value="{{ old('monto_gastado', 0) }}">
        </div>

        <button type="submit">Guardar</button>
    </form>
</div>
@endsection