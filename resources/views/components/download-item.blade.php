@props(['file'])

<div class="p-5 flex justify-between items-center hover:bg-slate-50 transition">
    <div class="flex items-center space-x-4">
        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-lg">
            {{-- Ikon SVG untuk file --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-slate-800">{{ $file->nama_file }}</h4>
            <p class="text-sm text-slate-500">Ukuran: {{-- Fungsi untuk format ukuran file --}} | Format: {{ strtoupper($file->format) }}
            </p>
        </div>
    </div>
    <a href="{{-- route untuk download --}}"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-indigo-700 transition">Download</a>
</div>
