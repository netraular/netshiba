<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $project->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="description">Descripción</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="category_id">Categoría</label>
    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
        <option value="">Selecciona una categoría</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id', $project->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="status_id">Estado</label>
    <select name="status_id" class="form-control @error('status_id') is-invalid @enderror" required>
        <option value="">Selecciona un estado</option>
        @foreach($statuses as $status)
        <option value="{{ $status->id }}" {{ old('status_id', $project->status_id ?? '') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
        @endforeach
    </select>
    @error('status_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <p for="logo">Logo del Proyecto</p>
    <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" id="logoInput" accept="image/*">
    <div id="croppedLogo" style="display: none; margin-top: 10px;">
        <img id="output" src="{{ asset('storage/' . ($project->logo ?? '')) }}" alt="Logo recortado" >
    </div>
    @error('logo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <p for="background">Banner del Proyecto</p>
    <input type="file" name="background" class="form-control-file @error('background') is-invalid @enderror" id="backgroundInput" accept="image/*">
    <div id="backgroundPreview" style="display: none; margin-top: 10px;">
        <img id="backgroundOutput" src="{{ asset('storage/' . ($project->background ?? '')) }}" alt="Banner" style="max-width: 300px;">
    </div>
    @error('background')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="complexity">Complejidad (1-10)</label>
    <div class="d-flex align-items-center">
        <input type="range" class="form-range @error('complexity') is-invalid @enderror" min="1" max="10" id="complexityRange" name="complexity" value="{{ old('complexity', $project->complexity ?? 1) }}" required>
        <input type="number" class="form-control ml-2 @error('complexity') is-invalid @enderror" id="complexityValue" min="1" max="10" name="complexity" value="{{ old('complexity', $project->complexity ?? 1) }}" style="width: 60px;" required>
    </div>
    @error('complexity')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="order">Orden</label>
    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" min="0" value="{{ old('order', $project->order ?? '') }}" required>
    @error('order')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label>Enlaces 
        <button type="button" class="btn btn-link text-success" onclick="addLinkInput()">
            <i class="bi bi-plus-square"></i>
        </button>
    </label>
    <div id="linksContainer">
        @if(isset($project) && $project->links)
            @foreach($project->links as $index => $link)
            <div class="input-group mb-3">
                <a style="font-size:22px;" href="{{ $link->url }}" class="px-2 py-0 btn btn-lg" title="{{ $link->name }}" target="_blank">
                    <i class="bi {{ $link->icon }}"></i>
                </a>
                <input type="text" name="link_icons[]" class="form-control link-icon-input" placeholder="Icono" value="{{ $link->icon }}" oninput="updateIcon(this)">
                <input type="text" name="link_names[]" class="form-control link-name-input" placeholder="Nombre del enlace" value="{{ $link->name }}" oninput="updateLinkTitle(this)">
                <input type="text" name="links[]" class="form-control link-url-input" placeholder="URL del enlace" value="{{ $link->url }}" oninput="updateLinkHref(this)">
                <div class="form-check form-check-inline d-flex align-items-center">
                    <input type="hidden" name="link_ids[]" value="{{ $link->id }}">
                    <input type="checkbox" name="link_hiddens[]" class="form-check-input p-2 m-1" value="{{ $link->id }}" {{ $link->hidden ? 'checked' : '' }}>
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
            </div>
            @endforeach
        @endif
    </div>
</div>
<div class="form-group">
    <label>Tags
        <button type="button" class="btn btn-link text-success" onclick="addTagInput()">
            <i class="bi bi-plus-square"></i>
        </button>
    </label>
    <div id="tagsContainer" class="row">
        @if(isset($project) && $project->tags)
            @foreach($project->tags as $tag)
            <div class="col-md-2 mb-2">
                <div class="input-group">
                    <input type="text" name="tags[]" class="form-control tag-input" placeholder="Tag" value="{{ $tag->name }}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-link text-danger pl-2" onclick="removeTag(this)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Logo cropper modal -->
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