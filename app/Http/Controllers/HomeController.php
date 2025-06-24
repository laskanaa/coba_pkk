<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Download;
use App\Models\ProgramUnggulan;
use App\Models\Menu; // Import the Menu model
use App\Models\Slider; // Import the Slider model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data program unggulan, urutkan berdasarkan kolom 'urutan'
        $programUnggulans = ProgramUnggulan::orderBy('urutan', 'asc')->get();

        // Ambil data lain yang sudah ada
        $beritas = Berita::latest()->take(2)->get();
        $downloads = Download::latest()->take(2)->get();

        // Ambil data menu dari database, urutkan berdasarkan kolom 'order'
        $menus = Menu::orderBy('order', 'asc')->get();

        // Ambil data slider dari database, urutkan berdasarkan kolom 'order'
        $sliders = Slider::orderBy('order')->get();

        // Kirim semua data ke view
        return view('pages.home', [
            'programUnggulans' => $programUnggulans,
            'beritas' => $beritas,
            'downloads' => $downloads,
            'menus' => $menus,
            'sliders' => $sliders, // Add slider data to the view
            // ... variabel lain
        ]);
    }
}
