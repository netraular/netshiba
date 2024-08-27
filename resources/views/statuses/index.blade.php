<!-- resources/views/statuses/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Estados</h1>
    <a href="{{ route('statuses.create') }}" class="btn btn-primary mb-3">Añadir Estado</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statuses as $status)
            <tr>
                <td><span class=" {{ $status->class }}">{{ $status->name }}</span></td>
                <td>{{ $status->description }}</td>
                <td>
                    <a href="{{ route('statuses.edit', $status) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('statuses.destroy', $status) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection