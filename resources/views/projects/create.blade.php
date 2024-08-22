<!-- resources/views/projects/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Proyecto</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control">
                <option value="En proceso">En proceso</option>
                <option value="Terminado">Terminado</option>
                <option value="Idea">Idea</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>
@endsection