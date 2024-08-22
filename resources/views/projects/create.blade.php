<!-- resources/views/projects/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Proyecto</h1>
    <form action="{{ route('projects.store') }}" method="POST" id="projectForm">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select name="category_id" class="form-control" id="categorySelect" required>
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control" required>
                <option value="">Selecciona un estado</option>
                @foreach($statuses as $status)
                <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Enlaces</label>
            <div id="linksContainer">
                <div class="input-group mb-2">
                    <input type="text" name="links[]" class="form-control link-input" placeholder="URL del enlace">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-link text-danger p-0" onclick="removeLink(this)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Tags</label>
            <div id="tagsContainer" class="row">
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

        <button type="submit" class="btn btn-primary">Añadir Proyecto</button>
    </form>
</div>

<script>
    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('link-input')) {
            const linksContainer = document.getElementById('linksContainer');
            const linkInputs = linksContainer.querySelectorAll('.link-input');
            const allFilled = Array.from(linkInputs).every(input => input.value.trim() !== '');

            if (allFilled) {
                addLinkInput();
            }

            updateRemoveButtons('link');
        }

        if (event.target.classList.contains('tag-input')) {
            const tagsContainer = document.getElementById('tagsContainer');
            const tagInputs = tagsContainer.querySelectorAll('.tag-input');
            const allFilled = Array.from(tagInputs).every(input => input.value.trim() !== '');

            if (allFilled) {
                addTagInput();
            }

            updateRemoveButtons('tag');
        }
    });

    function addLinkInput() {
        const linksContainer = document.getElementById('linksContainer');
        const newLinkGroup = document.createElement('div');
        newLinkGroup.className = 'input-group mb-2';
        newLinkGroup.innerHTML = `
            <input type="text" name="links[]" class="form-control link-input" placeholder="URL del enlace">
            <div class="input-group-append">
                <button type="button" class="btn btn-link text-danger p-0" onclick="removeLink(this)">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
        `;
        linksContainer.appendChild(newLinkGroup);
    }

    function removeLink(button) {
        button.closest('.input-group').remove();
        updateRemoveButtons('link');
    }

    function addTagInput() {
        const tagsContainer = document.getElementById('tagsContainer');
        const newTagGroup = document.createElement('div');
        newTagGroup.className = 'col-md-2 mb-2';
        newTagGroup.innerHTML = `
            <div class="input-group">
                <input type="text" name="tags[]" class="form-control tag-input" placeholder="Tag">
                <div class="input-group-append">
                    <button type="button" class="btn btn-link text-secondary p-0" onclick="removeTag(this)">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        `;
        tagsContainer.appendChild(newTagGroup);
    }

    function removeTag(button) {
        button.closest('.col-md-2').remove();
        updateRemoveButtons('tag');
    }

    function updateRemoveButtons(type) {
        const containerId = type === 'link' ? 'linksContainer' : 'tagsContainer';
        const inputClass = type === 'link' ? 'link-input' : 'tag-input';
        const container = document.getElementById(containerId);
        const inputs = container.querySelectorAll(`.${inputClass}`);
        const emptyInputs = Array.from(inputs).filter(input => input.value.trim() === '');

        inputs.forEach(input => {
            const removeButton = input.closest('.input-group').querySelector('button');
            if (emptyInputs.length === 1 && emptyInputs[0] === input) {
                removeButton.style.display = 'none';
            } else {
                removeButton.style.display = '';
            }
        });
    }

    // Initial call to ensure the correct state of remove buttons
    updateRemoveButtons('link');
    updateRemoveButtons('tag');
</script>
@endsection