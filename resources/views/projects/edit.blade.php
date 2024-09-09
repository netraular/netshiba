<!-- resources/views/projects/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Editar Proyecto</h1>
    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data" id="projectForm">
        @csrf
        @method('PUT')
        @include('projects.partials.form-fields', ['project' => $project])
        <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
    </form>
</div>

@vite('resources/js/projects/create.js')

@endsection