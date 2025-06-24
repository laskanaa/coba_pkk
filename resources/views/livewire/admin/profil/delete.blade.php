<div>
    <h2>Delete Profil</h2>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Delete Profil</h5>
        </div>
        <div class="card-body">
            <p>Are you sure you want to delete the profil titled "{{ $profil->title }}"?</p>
            <button wire:click="delete" class="btn btn-danger">Yes, Delete</button>
            <a href="{{ route('admin.profil.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</div>
