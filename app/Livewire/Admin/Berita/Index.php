<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Berita; // Assuming your model is here
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage; // Correct Facade for Storage

#[Layout('layouts.limitless')]
class Index extends Component
{
    use WithPagination;

    public string $pageTitle = 'Daftar Berita';
    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10]
    ];

    public function mount()
    {
        // Optional: You can set a default title if not already set
        // $this->pageTitle = 'Daftar Berita';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritas = Berita::where('judul', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.berita.index', [
            'beritas' => $beritas,
        ])->title($this->pageTitle); // Set the page title for the layout
    }

    /**
     * Triggers a SweetAlert confirmation dialog for deleting a news item.
     *
     * @param int $id The ID of the Berita item to delete.
     * @return void
     */
    public function delete($id)
    {
        $beritaId = (int) $id;
        $berita = Berita::find($beritaId); // Find to get the title for the message

        if (!$berita) {
            // Show error if berita not found
            $this->js("Swal.fire('Error!', 'Berita tidak ditemukan.', 'error');");
            return;
        }

        // Escape the title for use in JavaScript string
        $judulBerita = addslashes($berita->judul);

        // Use $this->js() to execute JavaScript for SweetAlert
        $this->js(<<<JS
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus berita "{$judulBerita}"? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Saja!',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                \$wire.confirmedDelete({$beritaId});
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
        $berita = Berita::findOrFail($id); // findOrFail will throw an exception if not found

        // Check if the Berita item has an image and if the image exists in storage
        // It's good practice to specify the disk, e.g., 'public'
        // Assumes $berita->image stores the path relative to the 'public' disk root (e.g., 'uploads/berita/image.jpg')
        if ($berita->image && Storage::disk('public')->exists($berita->image)) {
            Storage::disk('public')->delete($berita->image);
        }

        $berita->delete();

        // Set a flash message for session (optional, as SweetAlert is also used)
        // session()->flash('message', 'Berita berhasil dihapus!');

        // Show a success message using SweetAlert
        $this->js("Swal.fire('Dihapus!', 'Berita berhasil dihapus.', 'success');");

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
        $berita = Berita::findOrFail($id);
        $berita->status = $berita->status === 'publish' ? 'draft' : 'publish';
        $berita->save();

        $statusText = $berita->status === 'publish' ? 'dipublikasikan' : 'disimpan sebagai draft';
        $judulBerita = addslashes($berita->judul);

        // Show a success message using SweetAlert
        $this->js("Swal.fire('Berhasil!', 'Berita \"{$judulBerita}\" telah {$statusText}.', 'success');");

        // Optional: session flash message if needed for other purposes
        // session()->flash('message', "Status berita '{$berita->judul}' berhasil diubah menjadi {$statusText}.");
    }
}
