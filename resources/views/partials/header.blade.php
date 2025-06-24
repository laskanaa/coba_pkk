{{-- Kode untuk <header>...</header> --}}
<header x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }" class="bg-white/90 backdrop-blur-lg shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <img src="https://placehold.co/40x40/6366f1/ffffff?text=PKK" alt="Logo PKK Wonosobo"
                class="h-10 w-10 rounded-full">
            <div>
                <span class="text-xl font-bold text-slate-800">PKK Wonosobo</span>
                <p class="text-xs text-slate-500">Kabupaten Wonosobo</p>
            </div>
        </a>

        <!-- Menu Desktop -->
        <div class="hidden lg:flex items-center space-x-2">
            <a href="{{ route('home') }}#beranda"
                class="px-4 py-2 rounded-md text-slate-600 hover:bg-slate-100 hover:text-indigo-600 transition">Beranda</a>
            <div class="relative" @mouseleave="profileDropdownOpen = false">
                @foreach ($menus as $menu)
                    @if ($menu->parent_id == null)
                        <button @mouseover="profileDropdownOpen = true"
                            class="flex items-center px-4 py-2 rounded-md text-slate-600 hover:bg-slate-100 hover:text-indigo-600 transition">
                            <span>{{ $menu->title }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="profileDropdownOpen" @click.away="profileDropdownOpen = false"
                            @mouseover="profileDropdownOpen = true" @mouseleave="profileDropdownOpen = false"
                            x-transition class="absolute mt-2 w-48 bg-white rounded-lg shadow-xl z-20 py-1">
                            @foreach ($menus as $child)
                                @if ($child->parent_id == $menu->id)
                                    <a href="{{ $child->url }}"
                                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 ml-4">{{ $child->title }}</a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
            <a href="{{ route('home') }}#berita"
                class="px-4 py-2 rounded-md text-slate-600 hover:bg-slate-100 hover:text-indigo-600 transition">Berita</a>
            <a href="{{ route('home') }}#download"
                class="px-4 py-2 rounded-md text-slate-600 hover:bg-slate-100 hover:text-indigo-600 transition">Download</a>
            <a href="{{ route('home') }}#galeri"
                class="px-4 py-2 rounded-md text-slate-600 hover:bg-slate-100 hover:text-indigo-600 transition">Galeri</a>
        </div>

        <a href="{{ route('home') }}#kontak"
            class="hidden lg:inline-block bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-indigo-700 transition shadow-sm">Hubungi
            Kami</a>

        <!-- Tombol Menu Mobile -->
        <div class="lg:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Menu Mobile -->
    <div x-show="mobileMenuOpen" class="lg:hidden" @click.away="mobileMenuOpen = false">
        {{-- ... Kode menu mobile di sini ... --}}
    </div>
</header>
