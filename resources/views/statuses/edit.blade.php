<!-- resources/views/statuses/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Estado</h1>
    <form action="{{ route('statuses.update', $status) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $status->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" required>{{ $status->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection