<!-- resources/views/projects/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Proyectos</h1>
    @auth
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Añadir Proyecto</a>
    @endauth

    <!-- Zona superior para el buscador y filtros (a implementar) -->
    <div class="my-4">
        <!-- Aquí irá el buscador y los filtros -->
    </div>

    <!-- Mostrar proyectos por categorías -->
    @foreach($categories as $category)
        <h2>{{ $category->name }}</h2>
        <div class="row">
            @foreach($category->projects as $project)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text">{{ $project->description }}</p>
                            <p class="card-text">
                                @foreach($project->tags as $tag)
                                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                                @endforeach
                            </p>
                            <p class="card-text">
                                @foreach($project->links as $link)
                                    <a href="{{ $link->url }}" class="btn btn-link"><i class="fas fa-link"></i> {{ $link->name }}</a>
                                @endforeach
                            </p>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-info">Detalles</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection