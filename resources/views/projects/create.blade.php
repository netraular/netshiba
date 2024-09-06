@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Añadir Proyecto</h1>
    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

      
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">Selecciona un estado</option>
                @foreach($statuses as $status)
                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <p for="logo">Logo del Proyecto</p>
            <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" id="logoInput" accept="image/*">
            <div id="croppedLogo" style="display: none; margin-top: 10px;">
                <img id="output" src="#" alt="Logo recortado" >
            </div>
            @error('logo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <p for="background">Banner del Proyecto</p>
            <input type="file" name="background" class="form-control-file @error('background') is-invalid @enderror" id="backgroundInput" accept="image/*">
            <div id="backgroundPreview" style="display: none; margin-top: 10px;">
                <img id="backgroundOutput" src="#" alt="Banner" style="max-width: 300px;">
            </div>
            @error('background')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="complexity">Complejidad (1-10)</label>
            <div class="d-flex align-items-center">
                <input type="range" class="form-range @error('complexity') is-invalid @enderror" min="1" max="10" id="complexityRange" name="complexity" value="{{ old('complexity', 1) }}" required>
                <input type="number" class="form-control ml-2 @error('complexity') is-invalid @enderror" id="complexityValue" min="1" max="10" name="complexity" value="{{ old('complexity', 1) }}" style="width: 60px;" required>
            </div>
            @error('complexity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="order">Orden</label>
            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" min="0" value="{{ old('order') }}" required>
            @error('order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Enlaces</label>
            <div id="linksContainer">
                @foreach(old('links', ['']) as $index => $link)
                <div class="input-group mb-2">
                    <input type="text" name="link_icons[]" class="form-control" placeholder="Icono">
                    <input type="text" name="link_names[]" class="form-control" placeholder="Nombre del enlace">
                    <div class="form-check form-check-inline d-flex align-items-center">
                        <input type="hidden" name="link_ids[]" value="">
                        <input type="checkbox" name="link_hiddens[]" class="form-check-input p-2 m-1" value="">
                        <label class="form-check-label">Oculto</label>
                    </div>
                    <input type="text" name="links[]" class="form-control link-input" placeholder="URL del enlace">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-link text-danger" onclick="removeLink(this)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        <button type="button" class="btn btn-link text-primary" onclick="moveLinkUp(this)">
                            <i class="bi bi-arrow-up-circle"></i>
                        </button>
                        <button type="button" class="btn btn-link text-primary" onclick="moveLinkDown(this)">
                            <i class="bi bi-arrow-down-circle"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>Tags</label>
            <div id="tagsContainer" class="row">
                @foreach(old('tags', ['']) as $index => $tag)
                <div class="col-md-2 mb-2">
                    <div class="input-group">
                        <input type="text" name="tags[]" class="form-control tag-input" placeholder="Tag" value="{{ $tag }}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-link text-danger pl-2" onclick="removeTag(this)">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Añadir Proyecto</button>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Recortar Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="image" src="#" alt="Imagen a recortar" style="max-width: 100%; width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="cropButton">Aceptar</button>
            </div>
        </div>
    </div>
</div>

@vite('resources/js/projects/create.js')

@endsection