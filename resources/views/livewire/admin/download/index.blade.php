<div>
    {{-- Form Upload / Edit --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ $modeEdit ? 'Edit Dokumen' : 'Upload Dokumen' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" wire:model.defer="judul" class="form-control">
                    @error('judul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Upload File Baru</label>
                    <div x-data @drop.prevent="$wire.uploadMultiple('files', $event.dataTransfer.files)"
                        @dragover.prevent class="border rounded p-4 text-center bg-light" style="cursor: pointer"
                        onclick="this.querySelector('input[type=file]').click()">
                        <p>Drag & Drop file di sini atau klik untuk memilih</p>
                        <input type="file" multiple wire:model="files" class="d-none" />
                    </div>
                    @error('files.*')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- File Baru --}}
                @if (count($uploadedFiles))
                    <div class="mb-3">
                        <h6>File Baru:</h6>
                        <ul class="list-group">
                            @foreach ($uploadedFiles as $index => $file)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $file['name'] }}
                                    <button type="button" wire:click="removeFile({{ $index }})"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-sm btn-warning mt-2" wire:click="clearAllFiles">Hapus
                            Semua File Baru</button>
                    </div>
                @endif

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        {{ $modeEdit ? 'Simpan Perubahan' : 'Upload' }}
                    </button>
                    @if ($modeEdit)
                        <button type="button" class="btn btn-secondary" wire:click="resetForm">Batal Edit</button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Dokumen --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Dokumen</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 25%">Judul</th>
                            <th style="width: 45%">File</th>
                            <th style="width: 30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($downloads as $d)
                            <tr>
                                <td>{{ $d->judul }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach (json_decode($d->path, true) as $i => $file)
                                            <li class="mb-2">
                                                <strong>{{ $file['name'] }}</strong><br>
                                                <a href="{{ route('file.preview', ['path' => $file['path']]) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger mt-1"
                                                    wire:click="$dispatch('swal:confirm-delete-file', { id: {{ $d->id }}, index: {{ $i }} })">
                                                    <i class="fas fa-trash"></i> Hapus File Ini
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <div class="d-grid gap-2">
                                        <button wire:click="edit({{ $d->id }})" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            wire:click="$dispatch('swal:confirm-delete', { id: {{ $d->id }} })">
                                            <i class="fas fa-trash-alt"></i> Hapus Semua
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada dokumen diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('swal:confirm-delete', event => {
        Swal.fire({
            title: 'Hapus Dokumen?',
            text: "Semua file dalam dokumen ini akan terhapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteConfirmed', {
                    id: event.detail.id
                });
            }
        });
    });

    window.addEventListener('swal:confirm-delete-file', event => {
        Swal.fire({
            title: 'Hapus File Ini?',
            text: "File akan dihapus dari server.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteFileConfirmed', {
                    id: event.detail.id,
                    index: event.detail.index
                });
            }
        });
    });
</script>
