<!-- resources/views/notes/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Nota</h1>
    <form action="{{ route('notes.store', $project) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="explanation">Nota</label>
            <textarea name="explanation" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>
@endsection