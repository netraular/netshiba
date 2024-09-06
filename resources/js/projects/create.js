
// Image cropper

document.getElementById('logoInput').addEventListener('change', loadFile);
document.getElementById('backgroundInput').addEventListener('change', function(event) {
    const output = document.getElementById('backgroundOutput');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.maxWidth = '300px';
    document.getElementById('backgroundPreview').style.display = 'block';
});

function loadFile(event) {
    const inputId = event.target.id;
    const outputId = inputId === 'logoInput' ? 'output' : 'backgroundOutput';
    const croppedDivId = inputId === 'logoInput' ? 'croppedLogo' : 'backgroundPreview';
    const output = document.getElementById(outputId);
    
    // Guardar la imagen original mostrada antes del recorte
    const originalSrc = output.src; // Imagen previa antes de cambiarla por la nueva imagen
    
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.height = '8.75rem';
    output.style.width = '140px'; // Asegura que el ancho sea siempre 140px
    output.style.border = '2px dotted black';
    output.style.borderRadius = '6px';

    // Open the modal
    $('#cropModal').modal('show');
    // Destroy any existing cropper instance
    const image = document.getElementById('image');

    // Initialize the cropper
    image.src = URL.createObjectURL(event.target.files[0]); // Solo la última imagen subida
    var cropper = new Cropper(image, {
        aspectRatio: 1 / 1, // Square crop
        viewMode: 1,
        dragMode: 'move',
        autoCropArea: 1,
        cropBoxMovable: true,
        cropBoxResizable: true,
        responsive: true,
        restore: false,
        guides: false,
        center: false,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
    });

    // Handle the crop button click
    document.getElementById('cropButton').addEventListener('click', function () {
        const canvas = cropper.getCroppedCanvas();

        // Validar el tamaño de la imagen recortada
        canvas.toBlob(function (blob) {
            if (blob.size > 2 * 1024 * 1024) { // Control del tamaño de 2MB después de recortar
                alert('La imagen recortada no puede ser mayor a 2MB.');
                return; // Evitar enviar la imagen si es demasiado grande
            }

            const file = new File([blob], 'cropped_image.jpeg', { type: 'image/jpeg' });

            // Crear un DataTransfer para agregar el archivo recortado
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            // Asignar el archivo recortado al input correspondiente
            document.getElementById(inputId).files = dataTransfer.files;

            // Mostrar la imagen recortada en la vista previa
            output.src = canvas.toDataURL('image/jpeg', 0.9); // Mostrar la imagen recortada
            document.getElementById(croppedDivId).style.display = 'block';
            $('#cropModal').modal('hide'); // Cerrar el modal

            cropper.destroy();
        }, 'image/jpeg', 0.9); // Convertir a JPEG con 90% de calidad
    });

    // Handle the cancel button click
    document.querySelector('.btn-secondary').addEventListener('click', function () {
        // Restaura la imagen original (previa) si se cancela
        const canvas = cropper.getCroppedCanvas();

        // Mostrar la imagen recortada en la vista previa
        output.src = canvas.toDataURL('image/jpeg', 0.9); // Mostrar la imagen recortada
        output.src = originalSrc; // Restaurar la imagen original
        document.getElementById(croppedDivId).style.display = 'block'; // Asegurarse de que el div de la imagen esté visible
        $('#cropModal').modal('hide'); // Cerrar el modal
        cropper.destroy(); // Destruir la instancia del cropper
        image.src = ''; // Limpiar la imagen en el cropper
    });
}

//Link control
window.removeLink = function(button) {
    const linkGroup = button.closest('.input-group');
    const linksContainer = document.getElementById('linksContainer');
    const linkGroups = linksContainer.querySelectorAll('.input-group');

    // Verificar si hay más de un grupo de enlaces
    if (linkGroups.length > 1) {
        linkGroup.remove();
    } else {
        alert('No puedes eliminar el último enlace.');
    }
};
window.moveLinkUp = function(button) {
    const linkGroup = button.closest('.input-group');
    const prevLinkGroup = linkGroup.previousElementSibling;
    if (prevLinkGroup) {
        linkGroup.parentNode.insertBefore(linkGroup, prevLinkGroup);
    }
};

window.moveLinkDown = function(button) {
    const linkGroup = button.closest('.input-group');
    const nextLinkGroup = linkGroup.nextElementSibling;
    if (nextLinkGroup) {
        linkGroup.parentNode.insertBefore(nextLinkGroup, linkGroup);
    }
};

window.addLinkInput = function() {
    const linksContainer = document.getElementById('linksContainer');
    const newLinkGroup = document.createElement('div');
    newLinkGroup.className = 'input-group mb-3';
    newLinkGroup.innerHTML = `
        <a style="font-size:22px;" href="#" class="px-2 py-0 btn btn-lg" title="" target="_blank">
            <i class="bi bi-link-45deg"></i>
        </a>
        <input type="text" name="link_icons[]" class="form-control link-icon-input" placeholder="Icono" oninput="updateIcon(this)">
        <input type="text" name="link_names[]" class="form-control link-name-input" placeholder="Nombre del enlace" oninput="updateLinkTitle(this)">
        <input type="text" name="links[]" class="form-control link-url-input" placeholder="URL del enlace" oninput="updateLinkHref(this)">
        <div class="form-check form-check-inline d-flex align-items-center">
            <input type="hidden" name="link_ids[]" value="">
            <input type="checkbox" name="link_hiddens[]" class="form-check-input p-2 m-1" value="">
            <label class="form-check-label">Oculto</label>
        </div>
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
    `;
    linksContainer.appendChild(newLinkGroup);
}

window.updateIcon = function(input) {
    const linkElement = input.parentElement.querySelector('a');
    const iconClass = input.value.trim();
    
    // Limpiar clases anteriores
    linkElement.querySelector('i').className = 'bi';
    
    // Agregar la nueva clase del icono
    if (iconClass) {
        linkElement.querySelector('i').classList.add(iconClass);
    } else {
        // Si no hay valor, mostrar el icono por defecto
        linkElement.querySelector('i').classList.add('bi-link-45deg');
    }
}

window.updateLinkTitle = function(input) {
    const linkElement = input.parentElement.querySelector('a');
    linkElement.title = input.value.trim();
}

window.updateLinkHref = function(input) {
    const linkElement = input.parentElement.querySelector('a');
    linkElement.href = input.value.trim() || '#';

    // Verificar si el enlace actual es el último
    const linkGroups = document.querySelectorAll('#linksContainer .input-group');
    const lastLinkGroup = linkGroups[linkGroups.length - 1];

    if (input.parentElement === lastLinkGroup) {
        // Agregar un nuevo grupo de enlaces si el enlace actual es el último
        addLinkInput();
    }
}

function removeLink(button) {
    button.closest('.input-group').remove();
}

window.removeTag = function(button) {
    const tagGroup = button.closest('.col-md-2');
    const tagsContainer = document.getElementById('tagsContainer');
    const tagGroups = tagsContainer.querySelectorAll('.col-md-2');

    // Verificar si hay más de un grupo de etiquetas
    if (tagGroups.length > 1) {
        tagGroup.remove();
    } else {
        alert('No puedes eliminar la última etiqueta.');
    }
};

window.addTagInput = function() {
    const tagsContainer = document.getElementById('tagsContainer');
    const newTagGroup = document.createElement('div');
    newTagGroup.className = 'col-md-2 mb-2';
    newTagGroup.innerHTML = `
        <div class="input-group">
            <input type="text" name="tags[]" class="form-control tag-input" placeholder="Tag">
            <div class="input-group-append">
                <button type="button" class="btn btn-link text-danger pl-2" onclick="removeTag(this)">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
        </div>
    `;
    tagsContainer.appendChild(newTagGroup);
}


document.addEventListener('input', function(event) {
    if (event.target.classList.contains('link-input')) {
        const linksContainer = document.getElementById('linksContainer');
        const linkInputs = linksContainer.querySelectorAll('.link-input');
        const allFilled = Array.from(linkInputs).every(input => input.value.trim() !== '');

        if (allFilled) {
            addLinkInput();
        }
    } else if (event.target.classList.contains('tag-input')) {
        const tagsContainer = document.getElementById('tagsContainer');
        const tagInputs = tagsContainer.querySelectorAll('.tag-input');
        const allFilled = Array.from(tagInputs).every(input => input.value.trim() !== '');

        if (allFilled) {
            addTagInput();
        }
    }
});


// Control slider
document.getElementById('complexityRange').addEventListener('input', function() {
    document.getElementById('complexityValue').value = this.value;
});

document.getElementById('complexityValue').addEventListener('input', function() {
    document.getElementById('complexityRange').value = this.value;
});
