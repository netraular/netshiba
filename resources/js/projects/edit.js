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

window.removeLink = function(button) {
    const inputGroup = button.closest('.input-group');
    const deleteInput = inputGroup.querySelector('input[name="link_delete[]"]');
    deleteInput.value = "true";
    inputGroup.style.display = 'none';
}

window.removeTag = function(button) {
    button.closest('.input-group').remove();
}