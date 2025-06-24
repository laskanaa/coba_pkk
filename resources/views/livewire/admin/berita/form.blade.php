<div class="container-fluid">
    <h1 class="mb-4">Tambah Berita</h1>

    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"></h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                    <a class="list-icons-item" data-action="remove"></a>
                </div>
            </div>
        </div>
        <div class="card-body shadow-sm">
            <form wire:submit.prevent="submit" enctype="multipart/form-data" class="">
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Judul</label>
                    <div class="col-lg-10">
                        <input type="text" wire:model.defer="judul" class="form-control">
                        @error('judul')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Kategori</label>
                    <div class="col-lg-10">
                        <select wire:model.defer="kategori" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Pokja I">Pokja I</option>
                            <option value="Pokja II">Pokja II</option>
                            <option value="Pokja III">Pokja III</option>
                            <option value="Pokja IV">Pokja IV</option>
                        </select>
                        @error('kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Gambar Sampul</label>
                    <div class="col-lg-10">
                        {{-- Input File --}}
                        <input type="file" wire:model="image" class="form-control">

                        {{-- Error --}}
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        {{-- Loading Spinner --}}
                        <div wire:loading wire:target="image" class="mt-2">
                            <div class="spinner-border text-primary" role="status"
                                style="width: 1.5rem; height: 1.5rem;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span class="ml-2">Mengunggah gambar...</span>
                        </div>

                        {{-- Preview --}}
                        @if ($image)
                            <div class="mt-3">
                                <p>Preview:</p>
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview Gambar" class="img-thumbnail"
                                    style="max-height: 200px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Tag (dipisah koma)</label>
                    <div class="col-lg-10">
                        <input type="text" wire:model.defer="tag" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Tanggal Rilis</label>
                    <div class="col-lg-10">
                        <input type="date" wire:model.defer="tanggal" class="form-control">
                        @error('tanggal')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row" wire:ignore>
                    <label class="col-form-label col-lg-2">Isi Berita</label>
                    <div class="col-lg-10">
                        <textarea id="isi-editor" class="form-control" rows="10">{{ old('isi', $isi) }}</textarea>
                        @error('isi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Status</label>
                    <div class="col-lg-10">
                        <select wire:model.defer="status" class="form-control">
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            CKEDITOR.replace('isi-editor', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload') }}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.instances['isi-editor'].on('change', function() {
                // Livewire.dispatch('setIsiFromCkeditor', CKEDITOR.instances['isi-editor'].getData());
                const data = this.getData();
                Livewire.dispatch('setIsiFromCkeditor', {
                    value: data
                });
            });
        </script>
    @endpush

</div>
