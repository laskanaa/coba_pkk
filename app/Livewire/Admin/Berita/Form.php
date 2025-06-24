<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

#[Layout('layouts.limitless')]
class Form extends Component
{
    use WithFileUploads;

    public string $judul = '';
    public string $kategori = '';
    public $image;
    public string $tag = '';
    public string $tanggal = '';
    public string $isi = '';
    public string $status = 'draft';


    #[On('setIsiFromCkeditor')]
    public function setIsiFromCkeditor($value)
    {
        $this->isi = $value;
    }

    public function submit()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Pokja I,Pokja II,Pokja III,Pokja IV',
            'image' => 'nullable|image|max:2048',
            'tag' => 'nullable|string',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'status' => 'required|in:draft,publish',
        ]);

        $path = $this->image ? $this->image->store('berita-images', 'public') : null;

        Berita::create([
            'judul' => $this->judul,
            'kategori' => $this->kategori,
            'image' => $path,
            'tag' => $this->tag,
            'tanggal' => $this->tanggal,
            'isi' => $this->isi,
            'status' => $this->status,
        ]);

        $this->js(<<<JS
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Berita berhasil disimpan.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/berita';
            }
        });
    JS);
    }




    public function render()
    {
        return view('livewire.admin.berita.form');
    }
}
class UploadGambar extends Component
{
    use WithFileUploads;

    public $image;

    public function removeImage()
    {
        $this->reset('image');
    }

    public function render()
    {
        return view('livewire.upload-gambar');
    }
}
