<?php

namespace App\Livewire\Admin\Profil;

use App\Models\Profil;
use Livewire\Component;

class Edit extends Component
{
    public Profil $profil;
    public $title;
    public $content;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ];

    public function mount(Profil $profil)
    {
        $this->profil = $profil;
        $this->title = $profil->title;
        $this->content = $profil->content;
    }

    public function update()
    {
        $this->validate();

        $this->profil->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Profil updated successfully.');

        return redirect()->route('admin.profil.index');
    }

    public function render()
    {
        return view('livewire.admin.profil.edit');
    }
}
