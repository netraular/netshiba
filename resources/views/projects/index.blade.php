<!-- resources/views/projects/index.blade.php -->
@extends('layouts.app')

@section('content')

<link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet">
<script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

<div class="container-fluid">
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
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <!-- First Zone: Background Image -->
                    <div class="card-img-top" style="@if(isset($project->background)) background-image: url('{{ asset('storage/'.$project->background) }}'); @endif height: 150px; background-size: cover; background-position: center; position: relative;">
                        <!-- Button for logged users -->
                        @auth
                        <div class="dropdown position-absolute top-0 end-0 m-2" style="z-index: 1;">
                            <button class="btn btn-secondary dropdown-toggle bg-dark" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('projects.show', $project) }}">Detalles</a></li>
                                <li><a class="dropdown-item" href="{{ route('projects.edit', $project) }}">Editar</a></li>
                                <li>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proyecto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Eliminar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endauth
                        <!-- Second Zone: Project Logo -->
                        <div class="d-flex justify-content-center align-items-center" style="position: absolute; bottom: -50px; left: 50%; transform: translateX(-50%);">
                            @if($project->logo)
                                <a target="_blank" href="{{ $project->links->first()->url ?? '#' }}" class="logo-link">
                                    <img src="{{ asset('storage/'.$project->logo) }}" alt="{{ $project->name }}" class="rounded-circle bg-secondary" style="width: 100px; height: 100px;">
                                </a>
                            @else
                                <div class="text-center bg-secondary" style="width: 100px; height: 100px; line-height: 100px; border-radius: 50%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    {{ $project->name }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body" style="margin-top: 50px;">
                        <!-- Second Zone: Project Name -->
                        <h4 class="card-title text-center fw-bold">{{$project->name}}</h4>
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
                        <p class="card-text text-center">
                            @foreach($project->links as $link)
                                @if($link->hidden == 0 || ($link->hidden == 1 && Auth::check()))
                                    <a style="font-size:22px;" href="{{ $link->url }}" class="px-2 py-0 btn btn-lg " title="{{ $link->name }}">
                                        <i class=" {{ $link->hidden ? 'text-secondary' : '' }} {{ $link->icon }}"></i>
                                    </a>
                                @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection