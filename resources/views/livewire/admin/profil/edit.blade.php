<div>
    <h2>Edit Profil</h2>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Profil</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" class="form-control" wire:model="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" class="form-control" wire:model="content" rows="10"></textarea>
                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.profil.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
