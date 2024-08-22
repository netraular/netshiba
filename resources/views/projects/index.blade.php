<!-- resources/views/projects/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Proyectos</h1>
    @auth
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Añadir Proyecto</a>
    @endauth
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Tags</th>
                <th>Enlaces</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->category->name }}</td>
                <td>{{ $project->tags->pluck('name')->implode(', ') }}</td>
                <td>
                    @foreach($project->links as $link)
                    <a href="{{ $link->url }}">{{ $link->name }}</a><br>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-info">Detalles</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection