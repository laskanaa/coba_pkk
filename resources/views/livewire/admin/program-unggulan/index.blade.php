<div>
    {{-- Page header (Struktur standar Limitless) --}}
    <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-star-full2 mr-2"></i> <span class="font-weight-semibold">Program Unggulan</span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    {{-- /page header --}}


    {{-- Page content --}}
    <div class="content pt-0">

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        @endif

        <!-- Card Utama untuk Tabel Data -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Daftar Program Unggulan</h5>
                <div class="header-elements">
                    <button type="button" wire:click="create()" class="btn btn-primary">
                        <i class="icon-plus22 mr-2"></i> Tambah Program
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                        placeholder="Cari berdasarkan nama program...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Urutan</th>
                            <th>Nama Program</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programs as $program)
                            <tr>
                                <td>{{ $program->urutan }}</td>
                                <td>{{ $program->nama_program }}</td>
                                <td>{{ $program->deskripsi }}</td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <button type="button" wire:click="edit({{ $program->id }})"
                                            class="btn btn-warning btn-sm list-icons-item" title="Edit">
                                            <i class="icon-pencil7"></i>
                                        </button>
                                        <button type="button" wire:click="delete({{ $program->id }})"
                                            wire:confirm="Anda yakin ingin menghapus program ini?"
                                            class="btn btn-danger btn-sm list-icons-item" title="Hapus">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $programs->links() }}
            </div>
        </div>
        <!-- /card utama -->

    </div>
    {{-- /page content --}}


    {{-- Modal Form Tambah/Edit (Style Limitless/Bootstrap) --}}
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block;" tabindex="-1" x-data>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">{{ $programId ? 'Edit' : 'Tambah' }} Program Unggulan</h5>
                        <button type="button" class="close" wire:click="closeModal()">×</button>
                    </div>

                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="font-weight-semibold">Nama Program</label>
                                <input type="text" wire:model.defer="nama_program"
                                    class="form-control @error('nama_program') is-invalid @enderror" required>
                                @error('nama_program')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-semibold">Deskripsi</label>
                                <textarea wire:model.defer="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror"
                                    required></textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-semibold">Pilih Ikon Program</label>

                                <div style="overflow-x: auto; white-space: nowrap;" class="pb-2">
                                    <div class="d-flex flex-nowrap" style="gap: 1rem;">
                                        @foreach ($predefinedIcons as $label => $svg)
                                            <div class="text-center" style="width: 90px;">
                                                <div class="cursor-pointer border rounded-circle p-3 mx-auto {{ $ikon_svg === $svg ? 'border-primary bg-light' : 'border-secondary' }}"
                                                    wire:click="$set('ikon_svg', @js($svg))"
                                                    style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                                    {!! $svg !!}
                                                </div>
                                                <small class="d-block mt-1">{{ $label }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-semibold">Warna Tema</label>
                                <select wire:model.defer="warna_tema" class="form-control">
                                    <option value="">-- Pilih Warna --</option>
                                    @foreach ($predefinedColors as $label => $class)
                                        <option value="{{ $class }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-semibold">Nomor Urut</label>
                                <input type="number" wire:model.defer="urutan"
                                    class="form-control @error('urutan') is-invalid @enderror" required>
                                @error('urutan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal()" class="btn btn-light">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Backdrop untuk modal --}}
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
