<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Slider;
use Livewire\WithFileUploads;

class Sliders extends Component
{
    use WithFileUploads;

    public $image;
    public $title;
    public $description;

    public function render()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('livewire.admin.sliders', [
            'sliders' => $sliders,
        ]);
    }

    public function save()
    {
        $this->validate([
            'image' => 'image|max:1024',
            'title' => 'required',
            'description' => 'required',
        ]);

        $imagePath = $this->image->store('sliders', 'public');

        Slider::create([
            'image_path' => $imagePath,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Slider created successfully.');
    }
}
