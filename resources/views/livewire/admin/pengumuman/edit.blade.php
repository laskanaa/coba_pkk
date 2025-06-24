<div class="container-fluid">
    <h4 class="mb-4">Edit Pengumuman</h4>

    <form wire:submit.prevent="update" enctype="multipart/form-data" class="card card-body shadow-sm">

        {{-- Judul --}}
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Judul</label>
            <div class="col-lg-10">
                <input type="text" wire:model.defer="judul" class="form-control">
                @error('judul')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Tag --}}
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Tag</label>
            <div class="col-lg-10">
                <input type="text" wire:model.defer="tag" class="form-control">
            </div>
        </div>

        {{-- Tanggal Rilis --}}
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Tanggal Diumumkan</label>
            <div class="col-lg-10">
                <input type="date" wire:model.defer="tanggal" class="form-control">
                @error('tanggal')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Gambar Sampul --}}
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Gambar Sampul</label>
            <div class="col-lg-10">
                @if ($pengumuman->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $pengumuman->image) }}" width="150">
                    </div>
                @endif
                <input type="file" wire:model="image" class="form-control">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Isi Pengumuman --}}
        <div class="form-group row" wire:ignore>
            <label class="col-form-label col-lg-2">Isi Pengumuman</label>
            <div class="col-lg-10">
                <textarea id="isi-editor" class="form-control" rows="10">{{ $isi }}</textarea>
                @error('isi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2 text-right">
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                <button class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>

    {{-- CKEditor Script --}}
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
