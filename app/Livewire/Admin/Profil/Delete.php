<?php

namespace App\Livewire\Admin\Profil;

use App\Models\Profil;
use Livewire\Component;

class Delete extends Component
{
    public Profil $profil;

    public function mount(Profil $profil)
    {
        $this->profil = $profil;
    }

    public function delete()
    {
        $this->profil->delete();

        session()->flash('message', 'Profil deleted successfully.');

        return redirect()->route('admin.profil.index');
    }

    public function render()
    {
        return view('livewire.admin.profil.delete');
    }
}
