<?php

namespace App\Livewire\Admin\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.limitless')]
class Edit extends Component
{
    use WithFileUploads;

    public Pengumuman $pengumuman;

    public string $judul = '';
    public string $kategori = '';
    public string $tag = '';
    public $tanggal;
    public string $isi = '';
    public $image;

    public function mount($id)
    {
        $this->pengumuman = Pengumuman::findOrFail($id);
        $this->judul = $this->pengumuman->judul;
        $this->tag = $this->pengumuman->tag;
        $this->tanggal = \Carbon\Carbon::parse($this->pengumuman->tanggal)->format('Y-m-d');
        $this->isi = $this->pengumuman->isi;
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
            'tag' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            $path = $this->image->store('pengumuman-images', 'public');
            $this->pengumuman->image = $path;
        }

        $this->pengumuman->update([
            'judul' => $this->judul,
            'tag' => $this->tag,
            'tanggal' => $this->tanggal,
            'isi' => $this->isi,
            'image' => $this->pengumuman->image,
        ]);

        $this->js(<<<JS
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Edit berhasil.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/pengumuman';
            }
        });
    JS);
    }

    public function render()
    {
        return view('livewire.admin.pengumuman.edit');
    }
}
