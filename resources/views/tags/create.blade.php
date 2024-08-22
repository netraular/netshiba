<!-- resources/views/tags/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Tag</h1>
    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>
@endsection