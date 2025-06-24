<?php

namespace App\Livewire\Admin\Profil;

use App\Models\Profil;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $content;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ];

    public function save()
    {
        $this->validate();

        Profil::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Profil created successfully.');

        return redirect()->route('admin.profil.index');
    }

    public function render()
    {
        return view('livewire.admin.profil.create');
    }
}
