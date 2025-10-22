@extends('layouts.appMhs')

@section('title', 'Gallery')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">Gallery</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    {{-- Show entries --}}
    <div class="flex justify-end mb-6">
        <label class="flex items-center gap-2 text-sm">
            Show
            <select name="per_page" class="border rounded px-2 py-1" onchange="this.form.submit()">
                @foreach ([10, 20, 30] as $n)
                    <option value="{{ $n }}" {{ (int) request('per_page', $perPage) === $n ? 'selected' : '' }}>
                        {{ $n }}</option>
                @endforeach
            </select>
            entries
        </label>
    </div>

    @php
        // array gambar dari public/
        $images = ['G1.png', 'G2.png', 'G3.png'];
    @endphp

    {{-- Grid 3 kolom, total 15 kotak (5 baris)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($projects as $project)
            @php
                $cover = $project->display_cover_url ?? asset('images/placeholder.png'); // sediakan placeholder.png di public/images
            @endphp
            <figure class="bg-white shadow-md p-4 relative w-full " style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img src="{{ $cover }}" alt="{{ $project->title }}" class="w-full aspect-square object-cover"
                    loading="lazy" />
                <figcaption class="flex justify-center items-center space-x-6 mt-3 text-lg">
                    <i class="fas fa-heart text-red-600 cursor-pointer hover:scale-110 transition"></i>
                    <i class="fas fa-thumbs-down text-orange-500 cursor-pointer hover:scale-110 transition"></i>
                    <i class="fas fa-comment text-sky-500 cursor-pointer hover:scale-110 transition"></i>
                </figcaption>
            </figure>
        @empty
            <p class="col-span-full text-center text-gray-500">Belum ada proyek.</p>
        @endforelse
    </div> --}}

    {{-- Grid 3 kolom, dengan nama alias dan nama kategory --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($projects as $project)
            @php
                $cover = $project->display_cover_url ?? asset('images/placeholder.png');
            @endphp

            <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img src="{{ $cover }}" alt="{{ $project->title }}" class="w-full aspect-square object-cover"
                    loading="lazy" />

                <figcaption class="mt-3">
                    <h3 class="text-lg font-bold line-clamp-1">{{ $project->title }}</h3>
                    <p class="text-sm text-gray-600">
                        {{ $project->category ?? '-' }} • Smt {{ $project->semester ?? '-' }}
                        <br>
                        {{-- Tampilkan anonim_name saja; kalau null, tampilkan "-" atau teks lain sesuai selera --}}
                        by <span class="font-semibold">{{ $project->anonim_name ?? '-' }}</span>

                    </p>

                    <figcaption class="flex justify-center items-center space-x-6 mt-3 text-lg">
                        <i class="fas fa-heart text-red-600 cursor-pointer hover:scale-110 transition"></i>
                        <i class="fas fa-thumbs-down text-orange-500 cursor-pointer hover:scale-110 transition"></i>
                        <i class="fas fa-comment text-sky-500 cursor-pointer hover:scale-110 transition"></i>
                    </figcaption>
                </figcaption>
            </figure>
        @empty
            <p class="col-span-full text-center text-gray-500">Belum ada proyek.</p>
        @endforelse
    </div>


@endsection
