<!-- resources/views/tags/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tags</h1>
    <a href="{{ route('tags.create') }}" class="btn btn-primary mb-3">Añadir Tag</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->name }}</td>
                <td>
                    <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-warning">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection