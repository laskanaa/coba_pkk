@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2>{{ $berita->judul }}</h2>
            <p class="text-muted">Diposting pada: {{ $berita->created_at->translatedFormat('d F Y') }}</p>

            @if ($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid mb-4" alt="{{ $berita->judul }}">
            @endif

            <div class="isi-berita">
                {!! $berita->isi !!}
            </div>

            <div class="mt-4">
                <a href="/" class="btn btn-secondary">← Kembali</a>
            </div>
        </div>
    </section>
@endsection
