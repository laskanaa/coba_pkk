<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Berita;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.limitless')]
class Edit extends Component
{
    use WithFileUploads;

    public Berita $berita;

    public string $judul = '';
    public string $kategori = '';
    public string $tag = '';
    public $tanggal;
    public string $isi = '';
    public $image;

    public function mount($id)
    {
        $this->berita = Berita::findOrFail($id);
        $this->judul = $this->berita->judul;
        $this->kategori = $this->berita->kategori;
        $this->tag = $this->berita->tag;
        $this->tanggal = \Carbon\Carbon::parse($this->berita->tanggal)->format('Y-m-d');
        $this->isi = $this->berita->isi;
    }

    #[On('setIsiFromCkeditor')]
    public function setIsiFromCkeditor($value)
    {
        $this->isi = $value;
    }

    public function update()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Pokja I,Pokja II,Pokja III,Pokja IV',
            'tag' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            $path = $this->image->store('berita-images', 'public');
            $this->berita->image = $path;
        }

        $this->berita->update([
            'judul' => $this->judul,
            'kategori' => $this->kategori,
            'tag' => $this->tag,
            'tanggal' => $this->tanggal,
            'isi' => $this->isi,
            'image' => $this->berita->image,
        ]);

        $this->js(<<<JS
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Edit Berhasil..',
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
        return view('livewire.admin.berita.edit');
    }
}
