@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section id="beranda" class="relative h-[60vh] md:h-[90vh] ...">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($sliders as $key => $slider)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}"
                        class="@if ($key == 0) active @endif" aria-current="true"
                        aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($sliders as $key => $slider)
                    <div class="carousel-item @if ($key == 0) active @endif">
                        <img src="{{ asset('storage/' . $slider->image_path) }}" class="d-block w-100"
                            alt="{{ $slider->title }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $slider->title }}</h5>
                            <p>{{ $slider->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    {{-- Program Kerja Unggulan (POKJA) --}}
    <section id="pokja" class="py-20 md:py-28">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="section-title">Program Kerja Unggulan</h2>
                <p class="section-subtitle">Fokus utama kami terbagi dalam beberapa program kerja yang bersinergi untuk
                    kesejahteraan keluarga.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($programUnggulans as $program)
                    <div class="card text-center">
                        <div
                            class="mx-auto rounded-full w-20 h-20 flex items-center justify-center mb-6 {{ $program->warna_tema }} {{ str_replace(['bg-', '-100'], ['text-', '-600'], $program->warna_tema) }}">
                            {!! $program->ikon_svg !!}
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $program->nama_program }}</h3>
                        <p class="text-slate-600 text-sm">{{ $program->deskripsi }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Berita & Pengumuman --}}
    <section id="berita" class="py-20 md:py-28 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-16 gap-12">
                <div class="lg:col-span-2">
                    <div class="space-y-10">
                        @foreach ($beritas as $berita)
                            <x-berita-card :berita="$berita" />
                        @endforeach
                    </div>
                </div>
                <div id="pengumuman">
                    {{-- ... Konten pengumuman di sini ... --}}
                </div>
            </div>
        </div>
    </section>

    {{-- Area Download --}}
    <section id="download" class="py-20 md:py-28">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="section-title">Area Download</h2>
                <p class="section-subtitle">Unduh dokumen, formulir, dan materi penting lainnya...</p>
            </div>
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-md ...">
                    @foreach ($downloads as $download)
                        <x-download-item :file="$download" />
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ... Tambahan seksi lain seperti Galeri, dll jika ada ... --}}
@endsection
