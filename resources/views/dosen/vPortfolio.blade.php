@extends('layouts.appDosen')

@section('title', 'View Portfolio')

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
            <select class="border rounded px-2 py-1">
                <option>10</option>
                <option>20</option>
                <option>30</option>
            </select>
            entries
        </label>
    </div>

    @php
        // array gambar dari public/
        $images = ['G1.png', 'G2.png', 'G3.png'];
    @endphp

    {{-- Grid 3 kolom, total 15 kotak (5 baris) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @for ($i = 0; $i < 15; $i++)
            @php
                $image = $images[$i % count($images)];
            @endphp
            <figure class="bg-white shadow-md p-4 relative w-full " style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img src="{{ asset($image) }}" alt="Project {{ $i + 1 }}"
                    class="w-full aspect-square object-cover " loading="lazy" />
                <figcaption class="flex justify-center items-center space-x-6 mt-3 text-lg">
                    <i class="fas fa-heart text-red-600 cursor-pointer hover:scale-110 transition"></i>
                    <i class="fas fa-thumbs-down text-orange-500 cursor-pointer hover:scale-110 transition"></i>
                    <i class="fas fa-comment text-sky-500 cursor-pointer hover:scale-110 transition"></i>
                </figcaption>
            </figure>
        @endfor
    </div>
@endsection
