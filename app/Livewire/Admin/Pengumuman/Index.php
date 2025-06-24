<?php

namespace App\Livewire\Admin\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.limitless')]
class Index extends Component
{
    use WithPagination;

    public string $pageTitle = 'Daftar Pengumuman';
    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pengumumen = Pengumuman::where('judul', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.pengumuman.index', [
            'pengumumen' => $pengumumen,
        ]);
    }

    public function delete($id)
    {
        $pengumumanId = (int) $id;
        $pengumuman = Pengumuman::find($pengumumanId); // Find to get the title for the message

        if (!$pengumuman) {
            // Show error if berita not found
            $this->js("Swal.fire('Error!', 'Pengumuman tidak ditemukan.', 'error');");
            return;
        }

        // Escape the title for use in JavaScript string
        $judulPengumuman = addslashes($pengumuman->judul);

        // Use $this->js() to execute JavaScript for SweetAlert
        $this->js(<<<JS
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus berita "{$judulPengumuman}"? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Saja!',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                \$wire.confirmedDelete({$pengumumanId});
            }
        });
    JS);
    }

    /**
     * Handles the actual deletion of the Berita item after confirmation.
     * This method is called by the SweetAlert confirmation callback.
     *
     * @param int $id The ID of the Berita item to delete.
     * @return void
     */
    public function confirmedDelete($id)
    {
        $pengumuman = Pengumuman::findOrFail($id); // findOrFail will throw an exception if not found

        // Check if the Berita item has an image and if the image exists in storage
        // It's good practice to specify the disk, e.g., 'public'
        // Assumes $berita->image stores the path relative to the 'public' disk root (e.g., 'uploads/berita/image.jpg')
        if ($pengumuman->image && Storage::disk('public')->exists($pengumuman->image)) {
            Storage::disk('public')->delete($pengumuman->image);
        }

        $pengumuman->delete();

        // Set a flash message for session (optional, as SweetAlert is also used)
        // session()->flash('message', 'Berita berhasil dihapus!');

        // Show a success message using SweetAlert
        $this->js("Swal.fire('Dihapus!', 'Pengumuman berhasil dihapus.', 'success');");

        // Livewire will automatically re-render the component.
        // If you find the list doesn't update, you might need to explicitly
        // tell Livewire to refresh, e.g. by re-querying or using $this->dispatch('$refresh');
        // However, with pagination and standard operations, it usually updates correctly.
    }

    /**
     * Toggles the publish status of a Berita item.
     *
     * @param int $id The ID of the Berita item.
     * @return void
     */
    public function togglePublish($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->status = $pengumuman->status === 'publish' ? 'draft' : 'publish';
        $pengumuman->save();

        $statusText = $pengumuman->status === 'publish' ? 'dipublikasikan' : 'disimpan sebagai draft';
        $judulPengumuman = addslashes($pengumuman->judul);

        // Show a success message using SweetAlert
        $this->js("Swal.fire('Berhasil!', 'Pengumuman \"{$judulPengumuman}\" telah {$statusText}.', 'success');");

        // Optional: session flash message if needed for other purposes
        // session()->flash('message', "Status berita '{$berita->judul}' berhasil diubah menjadi {$statusText}.");
    }
}
