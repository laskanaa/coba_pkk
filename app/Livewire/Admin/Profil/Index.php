<?php

namespace App\Livewire\Admin\Profil;

use App\Models\Profil;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $profils = Profil::where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.profil.index', [
            'profils' => $profils,
        ]);
    }

    public function delete($id)
    {
        $profil = Profil::find($id);
        if ($profil) {
            $profil->delete();
        }
    }
}
