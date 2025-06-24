<?php

namespace App\Livewire\Admin\Profil;

use App\Models\PageContent;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class HalamanDinamis extends Component
{
    use WithFileUploads;

    public $slug;
    public $title;
    public $content;
    public $image;
    public $existingImage;

    protected $listeners = ['setIsiFromCkeditor'];

    public function mount($slug)
    {
        $page = PageContent::firstOrCreate(
            ['slug' => $slug],
            ['title' => ucwords(str_replace('-', ' ', $slug))]
        );

        $this->slug = $slug;
        $this->title = $page->title;
        $this->content = $page->content;
        $this->existingImage = $page->image;
    }

    public function setIsiFromCkeditor($value)
    {
        $this->content = $value;
    }


    public function save()
    {
        $this->validate([
            'image' => 'nullable|image|max:2048',
            'content' => 'nullable|string',
        ]);

        $imagePath = $this->existingImage;

        if ($this->image) {
            $imagePath = $this->image->store('gambar-sampul', 'public');
        }

        PageContent::updateOrCreate(
            ['slug' => $this->slug],
            [
                'title' => $this->title,
                'content' => $this->content,
                'image' => $imagePath,
            ]
        );

        $this->existingImage = $imagePath;
        session()->flash('success', 'Konten berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.profil.halaman-dinamis');
    }
}
