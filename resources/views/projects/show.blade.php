<!-- resources/views/projects/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $project->name }}</h1>
    <p>{{ $project->description }}</p>
    <p><strong>Categoría:</strong> {{ $project->category->name }}</p>
    <p><strong>Tags:</strong> {{ $project->tags->pluck('name')->implode(', ') }}</p>
    <p><strong>Enlaces:</strong></p>
    <ul>
        @foreach($project->links as $link)
        <li><a href="{{ $link->url }}">{{ $link->name }}</a></li>
        @endforeach
    </ul>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Volver a la lista</a>
</div>
@endsection