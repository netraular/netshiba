<!-- resources/views/categories/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Categoría</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>
@endsection