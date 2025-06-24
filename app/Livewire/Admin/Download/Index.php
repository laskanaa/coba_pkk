<?php

namespace App\Livewire\Admin\Download;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithFileUploads;

    public $judul;
    public $files = [];
    public $uploadedFiles = [];
    public $downloads;
    public $downloadId = null;
    public $modeEdit = false;

    public function mount()
    {
        $this->refreshData();
    }

    public function updatedFiles()
    {
        foreach ($this->files as $file) {
            $storedPath = $file->store('downloads', 'public');
            $this->uploadedFiles[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $storedPath,
            ];
        }

        $this->files = [];
    }

    public function removeFile($index)
    {
        if (isset($this->uploadedFiles[$index])) {
            Storage::disk('public')->delete($this->uploadedFiles[$index]['path']);
            unset($this->uploadedFiles[$index]);
            $this->uploadedFiles = array_values($this->uploadedFiles);
        }
    }

    #[\Livewire\Attributes\On('deleteFileConfirmed')]
    public function removeSingleFileFromSaved($id, $index)
    {
        if ($this->modeEdit && $this->downloadId === $id) {
            // Saat sedang edit
            if (isset($this->uploadedFiles[$index])) {
                Storage::disk('public')->delete($this->uploadedFiles[$index]['path']);
                unset($this->uploadedFiles[$index]);
                $this->uploadedFiles = array_values($this->uploadedFiles);
            }
        } else {
            // Mode biasa
            $download = Download::findOrFail($id);
            $files = json_decode($download->path, true);

            if (isset($files[$index])) {
                Storage::disk('public')->delete($files[$index]['path']);
                unset($files[$index]);
                $download->path = json_encode(array_values($files));
                $download->save();
            }

            $this->refreshData();
        }
    }

    public function clearAllFiles()
    {
        foreach ($this->uploadedFiles as $file) {
            Storage::disk('public')->delete($file['path']);
        }

        $this->uploadedFiles = [];
    }

    public function save()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'uploadedFiles' => 'required|array|min:1',
        ]);

        if ($this->modeEdit && $this->downloadId) {
            $download = Download::findOrFail($this->downloadId);
            $download->update([
                'judul' => $this->judul,
                'path' => json_encode($this->uploadedFiles), // langsung pakai versi terbaru yang sudah disinkronisasi
            ]);
        } else {
            Download::create([
                'judul' => $this->judul,
                'path' => json_encode($this->uploadedFiles),
            ]);
        }

        $this->resetForm();
        $this->refreshData();

        $this->js(<<<JS
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Dokumen berhasil disimpan.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    JS);
    }


    public function edit($id)
    {
        $download = Download::findOrFail($id);
        $this->downloadId = $id;
        $this->judul = $download->judul;
        $this->uploadedFiles = json_decode($download->path, true) ?? [];
        $this->modeEdit = true;
    }

    #[\Livewire\Attributes\On('deleteConfirmed')]
    public function deleteAllFiles($id)
    {
        $download = Download::findOrFail($id);
        $files = json_decode($download->path, true);

        foreach ($files as $file) {
            if (isset($file['path']) && Storage::disk('public')->exists($file['path'])) {
                Storage::disk('public')->delete($file['path']);
            }
        }

        $download->delete();
        $this->refreshData();
    }

    public function resetForm()
    {
        $this->reset(['judul', 'files', 'uploadedFiles', 'modeEdit', 'downloadId']);
    }

    public function refreshData()
    {
        $this->downloads = Download::latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.download.index');
    }
}
