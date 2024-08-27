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

    <!-- Mostrar proyectos -->
    <div class="row">
        @foreach($projects as $project)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <!-- First Zone: Background Image -->
                    <div class="card-img-top" style="background-image: url('{{ $project->background }}'); height: 150px; background-size: cover; background-position: center; position: relative;">
                        <!-- Button for logged users -->
                        @auth
                        <button class="btn btn-secondary position-absolute top-0 end-0 m-2" style="z-index: 1;">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        @endauth
                        <!-- Second Zone: Project Logo -->
                        <div class="d-flex justify-content-center align-items-center" style="position: absolute; bottom: -50px; left: 50%; transform: translateX(-50%);">
                            <img src="{{ $project->logo }}" alt="{{ $project->name }}" class="rounded-circle bg-secondary" style="width: 100px; height: 100px;">
                        </div>
                    </div>
                    <div class="card-body" style="margin-top: 50px;">
                        <!-- Second Zone: Project Name -->
                        <h4 class="card-title text-center fw-bold">{{ $project->name }}</h4>
                        <!-- Third Zone: Description -->
                        <p class="card-text">{{ $project->description }}</p>
                        <!-- Fourth Zone: Category and Tags -->
                        <p class="card-text">
                            <span class="badge {{ $project->category->class }}">{{ $project->category->name }}</span>
                            @foreach($project->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </p>
                        <!-- Fifth Zone: Links -->
                        <p class="card-text text-end">
                            @foreach($project->links as $link)
                                <a href="{{ $link->url }}" class="btn {{ $link->class }} mb-2" title="{{ $link->name }}">
                                    <i class="{{ $link->icon }}"></i>
                                </a>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection