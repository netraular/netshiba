<!-- resources/views/projects/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Proyecto</h1>
    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $project->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" required>{{ $project->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control" required>
                <option value="En proceso" {{ $project->status == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Terminado" {{ $project->status == 'Terminado' ? 'selected' : '' }}>Terminado</option>
                <option value="Idea" {{ $project->status == 'Idea' ? 'selected' : '' }}>Idea</option>
            </select>
        </div>
        <div class="form-group">
            <label for="logo">Logo del Proyecto</label>
            @if($project->logo)
            <div>
                <img src="{{ asset('storage/'.$project->logo) }}" alt="{{ $project->name }}" style="max-width: 100px; margin-bottom: 10px;">
            </div>
            @endif
            <input type="file" name="logo" class="form-control-file" accept="image/*">
        </div>
        <div class="form-group">
            <label for="background">Banner del Proyecto</label>
            @if($project->background)
            <div>
                <img src="{{ asset('storage/'.$project->background) }}" alt="{{ $project->name }}" style="max-width: 100px; margin-bottom: 10px;">
            </div>
            @endif
            <input type="file" name="background" class="form-control-file" accept="image/*">
        </div>
        <div class="form-group">
            <label for="complexity">Complejidad (1-10)</label>
            <div class="d-flex align-items-center">
                <input type="range" class="form-range" min="1" max="10" id="complexityRange" name="complexity" value="{{ $project->complexity }}" required>
                <input type="number" class="form-control ml-2" id="complexityValue" min="1" max="10" name="complexity" style="width: 60px;" value="{{ $project->complexity }}" required>
            </div>
        </div>
        <div class="form-group">
            <label for="order">Orden</label>
            <input type="number" name="order" class="form-control" min="0" value="{{ $project->order }}" required>
        </div>

        <div class="form-group">
            <label>Enlaces</label>
            <div id="linksContainer">
                @foreach($project->links as $link)
                <div class="input-group mb-2">
                    <input type="text" name="link_icons[]" class="form-control" value="{{ $link->icon }}" placeholder="Icono">
                    <input type="text" name="link_names[]" class="form-control" value="{{ $link->name }}" placeholder="Nombre del enlace">
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="link_ids[]" value="{{ $link->id }}">
                        <input type="checkbox" name="link_hiddens[]" class="form-check-input" value="{{ $link->id }}" {{ $link->hidden ? 'checked' : '' }}>
                        <label class="form-check-label">Oculto</label>
                    </div>
                    <input type="text" name="links[]" class="form-control link-input" value="{{ $link->url }}" placeholder="URL del enlace">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-link text-danger p-0" onclick="removeLink(this)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <input type="hidden" name="link_delete[]" value="false">
                </div>
                @endforeach
                <div class="input-group mb-2">
                    <input type="text" name="link_icons[]" class="form-control" placeholder="Icono">
                    <input type="text" name="link_names[]" class="form-control" placeholder="Nombre del enlace">
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="link_ids[]" value="">
                        <input type="checkbox" name="link_hiddens[]" class="form-check-input" value="">
                        <label class="form-check-label">Oculto</label>
                    </div>
                    <input type="text" name="links[]" class="form-control link-input" placeholder="URL del enlace">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-link text-danger p-0" onclick="removeLink(this)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <input type="hidden" name="link_delete[]" value="false">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Tags</label>
            <div id="tagsContainer" class="row">
                @foreach($project->tags as $tag)
                <div class="col-md-2 mb-2">
                    <div class="input-group">
                        <input type="text" name="tags[]" class="form-control tag-input" value="{{ $tag->name }}" placeholder="Tag">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-link text-secondary p-0" onclick="removeTag(this)">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-2 mb-2">
                    <div class="input-group">
                        <input type="text" name="tags[]" class="form-control tag-input" placeholder="Tag">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-link text-secondary p-0" onclick="removeTag(this)">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<script>
    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('link-input')) {
            const container = document.getElementById('linksContainer');
            const inputs = container.querySelectorAll('.link-input');
            const lastInput = inputs[inputs.length - 1];

            if (lastInput.value.trim() !== '') {
                const newInputGroup = document.createElement('div');
                newInputGroup.className = 'input-group mb-2';
                newInputGroup.innerHTML = `
                    <input type="text" name="link_icons[]" class="form-control" placeholder="Icono">
                    <input type="text" name="link_names[]" class="form-control" placeholder="Nombre del enlace">
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="link_ids[]" value="">
                        <input type="checkbox" name="link_hiddens[]" class="form-check-input" value="">
                        <label class="form-check-label">Oculto</label>
                    </div>
                    <input type="text" name="links[]" class="form-control link-input" placeholder="URL del enlace">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-link text-danger p-0" onclick="removeLink(this)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                    <input type="hidden" name="link_delete[]" value="false">
                `;
                container.appendChild(newInputGroup);
            }
        }

        if (event.target.classList.contains('tag-input')) {
            const container = document.getElementById('tagsContainer');
            const inputs = container.querySelectorAll('.tag-input');
            const lastInput = inputs[inputs.length - 1];

            if (lastInput.value.trim() !== '') {
                const newInputGroup = document.createElement('div');
                newInputGroup.className = 'col-md-2 mb-2';
                newInputGroup.innerHTML = `
                    <div class="input-group">
                        <input type="text" name="tags[]" class="form-control tag-input" placeholder="Tag">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-link text-secondary p-0" onclick="removeTag(this)">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(newInputGroup);
            }
        }
    });

    function removeLink(button) {
        const inputGroup = button.closest('.input-group');
        const deleteInput = inputGroup.querySelector('input[name="link_delete[]"]');
        deleteInput.value = "true";
        inputGroup.style.display = 'none';
    }

    function removeTag(button) {
        button.closest('.input-group').remove();
    }
</script>
@endsection