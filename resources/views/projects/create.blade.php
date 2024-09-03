<!-- resources/views/projects/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Añadir Proyecto</h1>
    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
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
            <label for="logo">Logo del Proyecto</label>
            <input type="file" name="logo" class="form-control-file" id="logoInput" accept="image/*">
            <div id="croppedLogo" style="display: none; margin-top: 10px;">
                <img id="croppedLogoImage" src="#" alt="Logo recortado" style="max-width: 100px;">
            </div>
        </div>
        <div class="form-group">
            <label for="background">Banner del Proyecto</label>
            <input type="file" name="background" class="form-control-file" accept="image/*">
        </div>
        <div class="form-group">
            <label for="complexity">Complejidad (1-10)</label>
            <div class="d-flex align-items-center">
                <input type="range" class="form-range" min="1" max="10" id="complexityRange" name="complexity" required>
                <input type="number" class="form-control ml-2" id="complexityValue" min="1" max="10" name="complexity" style="width: 60px;" required>
            </div>
        </div>
        <div class="form-group">
            <label for="order">Orden</label>
            <input type="number" name="order" class="form-control" min="0" required>
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

<!-- Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropperModalLabel">Recortar Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="imageToCrop" src="#" alt="Imagen a recortar" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="cropImageButton">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('input', function(event) {
        if (event.target.id === 'complexityRange') {
            document.getElementById('complexityValue').value = event.target.value;
        } else if (event.target.id === 'complexityValue') {
            document.getElementById('complexityRange').value = event.target.value;
        } else if (event.target.classList.contains('link-input')) {
            const linksContainer = document.getElementById('linksContainer');
            const linkInputs = linksContainer.querySelectorAll('.link-input');
            const allFilled = Array.from(linkInputs).every(input => input.value.trim() !== '');

            if (allFilled) {
                addLinkInput();
            }

            updateRemoveButtons('link');
        } else if (event.target.classList.contains('tag-input')) {
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

    // Cropper.js functionality
    let cropper;
    const logoInput = document.getElementById('logoInput');
    const imageToCrop = document.getElementById('imageToCrop');
    const croppedLogo = document.getElementById('croppedLogo');
    const croppedLogoImage = document.getElementById('croppedLogoImage');
    const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

    logoInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imageToCrop.src = e.target.result;
                cropperModal.show();
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1 / 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                    cropBoxMovable: false,
                    cropBoxResizable: false,
                    background: false,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('cropImageButton').addEventListener('click', function() {
        if (cropper) {
            const croppedCanvas = cropper.getCroppedCanvas();
            croppedLogoImage.src = croppedCanvas.toDataURL();
            croppedLogo.style.display = 'block';
            cropperModal.hide();
        }
    });

    document.getElementById('projectForm').addEventListener('submit', function(event) {
        if (cropper) {
            cropper.getCroppedCanvas().toBlob(function(blob) {
                const formData = new FormData(document.getElementById('projectForm'));
                formData.append('logo', blob);
                fetch(event.target.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.href = response.url;
                    } else {
                        alert('Error al subir la imagen');
                    }
                });
            });
            event.preventDefault();
        }
    });
</script>
@endsection