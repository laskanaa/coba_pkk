@props(['berita'])

<article class="flex flex-col md:flex-row items-start gap-6 group">
    <img src="{{ Storage::url($berita->gambar_utama) }}" alt="{{ $berita->judul }}"
        class="w-full md:w-56 h-auto object-cover rounded-lg shadow-md group-hover:opacity-90 transition-opacity">
    <div>
        <span class="text-sm font-semibold text-indigo-600">{{ $berita->pokja->nama_pokja ?? 'Umum' }}</span>
        <h3 class="text-xl font-bold mt-1 mb-2 hover:text-indigo-700 transition">
            <a href="#">{{ $berita->judul }}</a>
        </h3>
        <p class="text-slate-600 text-sm leading-relaxed mb-3">{{ Str::limit($berita->isi_berita, 150) }}</p>
        <time class="text-xs text-slate-500">{{ $berita->tanggal->translatedFormat('l, d F Y') }}</time>
    </div>
</article>
