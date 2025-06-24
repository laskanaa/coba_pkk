<div>
    <h2>Profil Index</h2>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">List Profil</h5>
            <div class="d-flex justify-content-between align-items-center">
                <input type="text" wire:model.live="search" placeholder="Search Profil..." class="form-control w-auto">
                <a href="{{ route('admin.profil.create') }}" class="btn btn-primary">Tambah Profil</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profils as $profil)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $profil->title }}</td>
                            <td>
                                <a href="{{ route('admin.profil.edit', $profil->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <button wire:click="delete({{ $profil->id }})"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No profils found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $profils->links() }}
        </div>
    </div>
</div>
