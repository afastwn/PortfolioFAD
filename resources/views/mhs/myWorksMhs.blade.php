@extends('layouts.appMhs')

@section('title', 'My Works')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">My Works</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    <section>
        {{-- menerima: $semesters, $hasAny, $nextSemester --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($semesters as $box)
                @php
                    /** @var \App\Models\Project|null $p */
                    $p = $box['project'];
                    $s = $box['semester'];
                    $exists = $box['exists'];
                    $cover = $box['cover_url'];
                @endphp

                {{-- ======== TILE: ADD PROJECT (awal kosong) ======== --}}
                @if (!$hasAny && $s === 1)
                    <a href="{{ route('mhs.projects.create') }}"
                        class="relative aspect-[4/3] bg-white rounded-2xl border-2 border-dashed flex flex-col items-center justify-center text-gray-600 hover:bg-gray-50">
                        <span class="text-xl font-semibold mb-2">Add Project</span>
                        <i class="fas fa-plus text-4xl"></i>

                        {{-- label semester kiri-bawah --}}
                        <span class="absolute left-4 bottom-3 text-xs text-gray-500">Semester
                            {{ $s }}</span>
                    </a>
                    @continue
                @endif

                {{-- ======== TILE: PROJECT ADA ======== --}}
                {{-- ======== TILE: PROJECT ADA ======== --}}
                @if ($exists)
                    <div class="relative bg-white rounded-2xl shadow overflow-hidden aspect-[4/3] flex flex-col">
                        {{-- Area cover (mengisi tinggi tersisa) --}}
                        <div class="flex-1 overflow-hidden">
                            @if ($cover)
                                <img src="{{ $cover }}" alt="Semester {{ $s }} cover"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <i class="far fa-image text-4xl mb-2"></i>
                                    <span>No Display Photo</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info bawah (tinggi konsisten) --}}
                        <div class="p-4">
                            <h3 class="font-extrabold text-lg truncate">{{ $p->title }}</h3>
                            <p class="text-sm text-gray-500 truncate">{{ $p->course ?: '—' }}</p>
                            <div class="text-xs mt-2 text-gray-600">Semester {{ $s }}</div>
                        </div>

                        {{-- Aksi pojok kanan bawah --}}
                        <div class="absolute right-3 bottom-3 flex gap-2">
                            {{-- <a href="{{ route('mhs.projects.show', $p) }}"
                                class="p-2 bg-white/90 rounded-full shadow hover:bg-white" title="View">
                                <i class="far fa-eye"></i>
                            </a> --}}
                            <a href="{{ route('mhs.projects.edit', $p) }}"
                                class="p-2 bg-white/90 rounded-full shadow hover:bg-white" title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                @else
                    @if ($hasAny && isset($nextSemester) && $s === $nextSemester)
                        <a href="{{ route('mhs.projects.create') }}"
                            class="relative aspect-[4/3] bg-white rounded-2xl border-2 border-dashed flex flex-col items-center justify-center text-gray-600 hover:bg-gray-50">
                            <span class="text-xl font-semibold mb-2">Add Project</span>
                            <i class="fas fa-plus text-4xl"></i>

                            {{-- label semester kiri-bawah --}}
                            <span class="absolute left-4 bottom-3 text-xs text-gray-500">Semester
                                {{ $s }}</span>
                        </a>
                    @else
                        {{-- Locked card kamu tetap seperti sebelumnya --}}
                        <div
                            class="relative bg-white rounded-2xl shadow flex flex-col items-center justify-center aspect-[4/3] text-gray-400">
                            <i class="fas fa-lock text-4xl mb-2"></i>
                            <div class="font-semibold">Locked</div>
                            <div class="text-sm italic">Complete Semester {{ max(1, $s - 1) }}</div>
                            <span class="absolute left-4 bottom-3 text-xs text-gray-500">Semester
                                {{ $s }}</span>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </section>

@endsection
