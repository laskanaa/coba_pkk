<?php

use App\Http\Controllers\ContohController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Contoh;
use App\Livewire\Admin\Berita\Form as BeritaForm;
use App\Livewire\Admin\Berita\Index as BeritaIndex;
use App\Livewire\Admin\Pengumuman\Index as PengumumanIndex;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Livewire\Admin\Berita\Edit;
use App\Livewire\Admin\Pengumuman\Edit as PengumumanEdit;
use App\Livewire\Admin\Download\Index;
use App\Livewire\Admin\Profil\Delete;
use App\Livewire\Admin\Profil\Create;
use App\Livewire\Admin\Profil\Edit as ProfilEdit;
use App\Http\Controllers\FilePreviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengumumanController;
use App\Livewire\Admin\Menus\Index as MenuIndex;
use App\Livewire\Admin\Profil\HalamanDinamis;
use App\Livewire\Admin\ProgramUnggulan\Index as ProgramUnggulanIndex;
use App\Models\Slider;
use App\Livewire\Admin\Sliders;

Route::post('/upload/ckeditor-image', function (Request $request) {
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/ckeditor', $filename);
        $url = Storage::url('ckeditor/' . $filename);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $url
        ]);
    }
    return response()->json(['uploaded' => 0, 'error' => ['message' => 'Upload gagal.']], 400);
})->name('ckeditor.upload')->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/berita', BeritaIndex::class)->name('berita.index');
    Route::get('/berita/tambah', \App\Livewire\Admin\Berita\Form::class)->name('berita.form');
    Route::get('/berita/{id}/edit', \App\Livewire\Admin\Berita\Edit::class)->name('berita.edit')->middleware('auth');
    Route::get('/pengumuman', PengumumanIndex::class)->name('pengumuman.index');
    Route::get('/pengumuman/tambah', \App\Livewire\Admin\Pengumuman\FormP::class)->name('pengumuman.form-p');
    Route::get('/pengumuman/{id}/edit', PengumumanEdit::class)->name('pengumuman.edit')->middleware('auth');
    Route::get('/download', Index::class)->name('download.index');
    Route::get('/user', \App\Livewire\Admin\User\Index::class)->name('user.index');
    Route::get('/menu', MenuIndex::class)->name('menu.index');
    Route::get('/profil', \App\Livewire\Admin\Profil\Index::class)->name('profil.index');
    Route::get('/profil/tambah', \App\Livewire\Admin\Profil\Create::class)->name('profil.create');
    Route::get('/profil/{id}/edit', \App\Livewire\Admin\Profil\Edit::class)->name('profil.edit')->middleware('auth');
    Route::get('/profil/{id}/delete', \App\Livewire\Admin\Profil\Delete::class)->name('profil.delete');
    Route::get('/profil/{slug}', HalamanDinamis::class)->name('profil.halaman-dinamis');
    Route::get('program-unggulan', ProgramUnggulanIndex::class)->name('program-unggulan.index');
    Route::get('/sliders', \App\Livewire\Admin\Sliders::class)->name('sliders');
});

Route::resource('contoh', ContohController::class);

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('/preview-file/{path}', [FilePreviewController::class, 'show'])
    ->where('path', '.*')
    ->name('file.preview');

require __DIR__ . '/auth.php';
