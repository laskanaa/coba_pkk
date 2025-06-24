<?php

namespace App\Livewire\Admin\ProgramUnggulan;

use App\Models\ProgramUnggulan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Properti untuk form (Create & Update)
    public $programId, $nama_program, $deskripsi, $ikon_svg, $warna_tema, $urutan;

    // Properti untuk modal
    public $isModalOpen = false;

    // Properti untuk pencarian dan filter
    public $search = '';

    // -- AWAL PERUBAHAN --

    // Properti untuk Pilihan Ikon
    public array $predefinedIcons = [];

    // Properti untuk Pilihan Warna
    public array $predefinedColors = [];

    // Fungsi mount() dijalankan saat komponen pertama kali di-load
    public function mount()
    {
        $this->predefinedIcons = $this->getIcons();
        $this->predefinedColors = $this->getColors();
    }

    private function getIcons(): array
    {
        // Anda bisa menambahkan ikon lain di sini
        return [
            'Pancasila' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a9.004 9.004 0 00-4.5 15.754M12 3a9.004 9.004 0 014.5 15.754" /></svg>',
            'Pendidikan' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>',
            'Sandang Pangan' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>',
            'Kesehatan' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>',
        ];
    }

    private function getColors(): array
    {
        return [
            'Merah' => 'bg-red-100',
            'Kuning' => 'bg-yellow-100',
            'Hijau' => 'bg-green-100',
            'Biru' => 'bg-blue-100',
            'Ungu' => 'bg-purple-100',
            'Pink' => 'bg-pink-100',
            'Abu-abu' => 'bg-gray-100',
        ];
    }

    // -- AKHIR PERUBAHAN --

    public function render()
    {
        // ... (fungsi render tidak berubah)
        $programs = ProgramUnggulan::where('nama_program', 'like', '%' . $this->search . '%')
            ->orderBy('urutan', 'asc')
            ->paginate(10);

        return view('livewire.admin.program-unggulan.index', [
            'programs' => $programs
        ])->layout('layouts.limitless');
    }

    // ... sisa fungsi lainnya (create, edit, store, delete, dll) tidak berubah ...
    public function create()
    {
        $this->resetForm();
        $this->openModal();
    }

    public function edit($id)
    {
        $program = ProgramUnggulan::findOrFail($id);
        $this->programId = $id;
        $this->nama_program = $program->nama_program;
        $this->deskripsi = $program->deskripsi;
        $this->ikon_svg = $program->ikon_svg;
        $this->warna_tema = $program->warna_tema;
        $this->urutan = $program->urutan;

        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'ikon_svg' => 'nullable|string',
            'warna_tema' => 'nullable|string',
            'urutan' => 'required|integer|min:1',
        ]);

        ProgramUnggulan::updateOrCreate(['id' => $this->programId], [
            'nama_program' => $this->nama_program,
            'deskripsi' => $this->deskripsi,
            'ikon_svg' => $this->ikon_svg,
            'warna_tema' => $this->warna_tema,
            'urutan' => $this->urutan,
        ]);

        session()->flash('success', $this->programId ? 'Program berhasil diperbarui.' : 'Program berhasil ditambahkan.');

        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        ProgramUnggulan::find($id)->delete();
        session()->flash('success', 'Program berhasil dihapus.');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
    }
    private function resetForm()
    {
        $this->programId = null;
        $this->nama_program = '';
        $this->deskripsi = '';
        $this->ikon_svg = '';
        $this->warna_tema = '';
        $this->urutan = 0;
    }
}
