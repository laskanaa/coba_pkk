<div class="card">
    <div class="card-header">
        <h5 class="card-title">Kelola Menu Profil & Submenu</h5>
    </div>

    <div class="card-body">
        <form wire:submit.prevent="save" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="title" class="form-label">Judul Menu</label>
                    <input wire:model="title" id="title" class="form-control" placeholder="Judul Menu">
                </div>
                <div class="col-md-3">
                    <label for="url" class="form-label">URL</label>
                    <input wire:model="url" id="url" class="form-control" placeholder="URL">
                </div>
                <div class="col-md-3">
                    <label for="parent_id" class="form-label">Menu Induk</label>
                    <select wire:model="parent_id" id="parent_id" class="form-control form-select">
                        <option value="">Menu Utama</option>
                        @foreach ($menuOptions as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="order" class="form-label">Urutan</label>
                    <input wire:model="order" id="order" type="number" class="form-control" placeholder="#">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 me-2" type="submit">
                        {{ $isEditing ? 'Update' : 'Tambah' }}
                    </button>
                    @if ($isEditing)
                        <button type="button" wire:click="resetForm" class="btn btn-secondary w-100">Batal</button>
                    @endif
                </div>
            </div>
        </form>

        <ul class="list-group">
            @foreach ($menus as $menu)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $menu->title }}</strong>
                        <small class="text-muted ms-2">{{ $menu->url }}</small>
                    </div>
                    <div class="btn-group btn-group-sm" role="group">
                        <button wire:click="edit({{ $menu->id }})" class="btn btn-warning">Edit</button>
                        <button wire:click="delete({{ $menu->id }})" class="btn btn-danger">Hapus</button>
                    </div>

                    @if ($menu->children->count())
                        <ul class="list-group list-group-flush mt-2 w-100">
                            @foreach ($menu->children as $child)
                                <li class="list-group-item d-flex justify-content-between align-items-center ps-4">
                                    <div>
                                        - {{ $child->title }}
                                        <small class="text-muted ms-2">{{ $child->url }}</small>
                                    </div>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $child->id }})"
                                            class="btn btn-warning">Edit</button>
                                        <button wire:click="delete({{ $child->id }})"
                                            class="btn btn-danger">Hapus</button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
