@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Añadir Proyecto</h1>
    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
        @csrf
        @include('projects.partials.form-fields', ['project' => null])
        <button type="submit" class="btn btn-primary">Añadir Proyecto</button>
    </form>
</div>

@vite('resources/js/projects/create.js')

@endsection