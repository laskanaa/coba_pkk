<div>
    @slot('bread')
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
            <span class="breadcrumb-item active">{{ $title }}</span>
        </div>
    @endslot

    {{-- Flash message --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    {{-- Form --}}
    <form wire:submit.prevent="save">
        <div class="form-group row">
            <label class="col-form-label col-lg-2">Gambar Sampul</label>
            <div class="col-lg-10">
                <input type="file" wire:model="image" class="form-control">

                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div wire:loading wire:target="image" class="mt-2">
                    <div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span class="ml-2">Mengunggah gambar...</span>
                </div>

                @if ($image)
                    <div class="mt-3">
                        <p>Preview:</p>
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview Gambar" class="img-thumbnail"
                            style="max-height: 200px;">
                    </div>
                @elseif ($existingImage)
                    <div class="mt-3">
                        <p>Gambar Saat Ini:</p>
                        <img src="{{ asset('storage/' . $existingImage) }}" alt="Gambar Lama" class="img-thumbnail"
                            style="max-height: 200px;">
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row" wire:ignore>
            <label class="col-form-label col-lg-2">Konten</label>
            <div class="col-lg-10">
                <textarea id="isi-editor" class="form-control" rows="10">{{ $content }}</textarea>
                @error('content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-group row mt-4">
            <div class="col-lg-10 offset-lg-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            CKEDITOR.replace('isi-editor', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.instances['isi-editor'].on('change', function() {
                const data = this.getData();
                Livewire.dispatch('setIsiFromCkeditor', {
                    value: data
                });
            });
        </script>
    @endpush
</div>
