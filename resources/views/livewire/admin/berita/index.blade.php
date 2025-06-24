@slot('bread')
    <div class="breadcrumb">
        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
        <span class="breadcrumb-item active">{{ $pageTitle ?? 'Dashboard' }}</span>
    </div>
@endslot
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Daftar Berita</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        {{-- Tombol tambah --}}
        <div class="mb-3">
            <a href="{{ route('admin.berita.form') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Berita
            </a>
        </div>
    </div>

    <div class="datatable-header d-flex justify-content-between align-items-center px-3 pt-2">
        <div class="dataTables_length">
            <label>
                <span>Show:</span>
                <select wire:model.live="perPage" class="form-control form-control-sm d-inline-block w-auto mx-2">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                entries
            </label>
        </div>

        <div class="dataTables_filter">
            <label>
                <span>Search:</span>
                <input type="search" wire:model.live.300ms="search"
                    class="form-control form-control-sm d-inline-block w-auto ml-2" placeholder="Type to search...">
            </label>
        </div>
    </div>

    <div class="datatable-scroll">
        <table class="table table-bordered table-hover datatable-basic">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal Publish</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($beritas as $index => $item)
                    <tr>
                        <td>{{ ($beritas->currentPage() - 1) * $beritas->perPage() + $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->tanggal->format('d M Y') }}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" {{ $item->status === 'publish' ? 'checked' : '' }}
                                    wire:click="togglePublish({{ $item->id }})">
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <div class="list-icons">
                                <a href="{{ route('admin.berita.edit', $item->id) }}"
                                    class="btn btn-outline-success rounded-round">
                                    <i class="mr-2 icon-zoomin3"></i>Edit
                                </a>
                                <button wire:click="delete({{ $item->id }})"
                                    class="btn btn-outline-danger rounded-round delete-data-table">
                                    <i class="mr-2 icon-trash"></i>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="datatable-footer d-flex justify-content-between align-items-center px-3 pb-3">
        <div class="dataTables_info">
            Showing {{ $beritas->firstItem() }} to {{ $beritas->lastItem() }} of {{ $beritas->total() }} entries
        </div>
        <div class="dataTables_paginate paging_simple_numbers">
            {{ $beritas->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    @push('styles')
        <style>
            /* Kontainer switch */
            .switch {
                position: relative;
                display: inline-block;
                width: 50px;
                height: 28px;
            }

            /* Sembunyikan checkbox */
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            /* Slider dasar */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }

            /* Bola dalam slider */
            .slider:before {
                position: absolute;
                content: "";
                height: 22px;
                width: 22px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }

            /* Jika dicentang */
            input:checked+.slider {
                background-color: #2196F3;
            }

            input:checked+.slider:before {
                transform: translateX(22px);
            }

            /* Opsional: untuk slider bulat */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }
        </style>
    @endpush

</div>
