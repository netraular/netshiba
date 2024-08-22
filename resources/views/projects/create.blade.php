<!-- resources/views/projects/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Proyecto</h1>
    <form action="{{ route('projects.store') }}" method="POST" id="projectForm">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" class="form-control">
                <option value="En proceso">En proceso</option>
                <option value="Terminado">Terminado</option>
                <option value="Idea">Idea</option>
            </select>
        </div>

        <div class="form-group">
            <label>Enlaces</label>
            <div id="linksContainer">
                <div class="input-group mb-2">
                    <input type="text" name="links[]" class="form-control link-input" placeholder="URL del enlace">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger" onclick="removeLink(this)" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
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

            updateRemoveButtons();
        }
    });

    function addLinkInput() {
        const linksContainer = document.getElementById('linksContainer');
        const newLinkGroup = document.createElement('div');
        newLinkGroup.className = 'input-group mb-2';
        newLinkGroup.innerHTML = `
            <input type="text" name="links[]" class="form-control link-input" placeholder="URL del enlace">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger" onclick="removeLink(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        linksContainer.appendChild(newLinkGroup);
        updateRemoveButtons();
    }

    function removeLink(button) {
        button.closest('.input-group').remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const linksContainer = document.getElementById('linksContainer');
        const linkInputs = linksContainer.querySelectorAll('.link-input');
        const emptyInputs = Array.from(linkInputs).filter(input => input.value.trim() === '');

        linkInputs.forEach(input => {
            const removeButton = input.closest('.input-group').querySelector('.btn-danger');
            if (emptyInputs.length === 1 && emptyInputs[0] === input) {
                removeButton.style.display = 'none';
            } else {
                removeButton.style.display = '';
            }
        });
    }

    // Initial call to ensure the correct state of remove buttons
    updateRemoveButtons();
</script>
@endsection