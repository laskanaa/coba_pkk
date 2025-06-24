@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2>{{ $pengumuman->judul }}</h2>
            <p class="text-muted">Tanggal: {{ $pengumuman->created_at->translatedFormat('d F Y') }}</p>

            <div class="isi-pengumuman">
                {!! $pengumuman->isi !!}
            </div>

            <div class="mt-4">
                <a href="/" class="btn btn-secondary">← Kembali</a>
            </div>
        </div>
    </section>
@endsection
