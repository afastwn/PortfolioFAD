@extends('layouts.appDosen')

@section('title', 'Profile')

@php
    // Ambil ID dari URL: /studentProfiling/{id}
    $id = request()->route('id');

    // Daftar yang sama seperti di studentProfiling (UI-only)
    $rows = [
        ['id' => '20462', 'name' => 'Matt Dickerson', 'cat' => 'Lighting Systems'],
        ['id' => '18933', 'name' => 'Wiktoria', 'cat' => 'Sports Equipment'],
        ['id' => '45169', 'name' => 'Trixie Byrd', 'cat' => 'Vehicle Accessories'],
        ['id' => '73003', 'name' => 'Jun Redfern', 'cat' => 'Watercraft'],
        ['id' => '58825', 'name' => 'Miriam Kidd', 'cat' => 'Robotics'],
        ['id' => '44122', 'name' => 'Dominic', 'cat' => 'Office Supplies and Stationery'],
        ['id' => '89094', 'name' => 'Shanice', 'cat' => 'Computer and Information Technology'],
        ['id' => '85252', 'name' => 'Poppy-Rose', 'cat' => 'Gaming and Streaming'],
        ['id' => '99001', 'name' => 'Aria', 'cat' => 'Gaming and Streaming'],
        ['id' => '99002', 'name' => 'Liam', 'cat' => 'Watches'],
        ['id' => '99003', 'name' => 'Noah', 'cat' => 'Sports Equipment'],
    ];

    // (Opsional) Detail tambahan per ID, sisanya pakai default
    $extra = [
        '20462' => ['phone' => '77777777', 'address' => 'Pati', 'email' => '@123'],
        '18933' => ['phone' => '22222', 'address' => 'Jogja', 'email' => '@w'],
        '45169' => ['phone' => '33333', 'address' => 'Bandung', 'email' => '@t'],
    ];

    // Cari data dasar berdasarkan ID
    $base = collect($rows)->firstWhere('id', $id);

    // Jika tidak ketemu, bisa abort(404) atau tampilkan placeholder
    if (!$base) {
        $base = ['id' => $id, 'name' => 'Unknown', 'cat' => '-'];
    }

    // Gabungkan dengan detail tambahan / default
    $detail = $extra[$base['id']] ?? ['phone' => '-', 'address' => '-', 'email' => '-'];

    // Dummy portfolio (UI-only)
    $portfolio = [
        ['title' => 'Project Title', 'course' => 'Course Name', 'semester' => 'Semester 1', 'img' => '/G1.png'],
        ['title' => 'Project Title', 'course' => 'Course Name', 'semester' => 'Semester 2', 'img' => '/G2.png'],
    ];

    // Bentuk objek $mhs agar kompatibel dengan template di bawah
    $mhs = (object) [
        'id' => $base['id'],
        'name' => $base['name'],
        'cat' => $base['cat'],
        'address' => $detail['address'],
        'email' => $detail['email'],
        'portfolio' => $portfolio,
    ];
@endphp

@section('content')
    <!-- Header -->
    <header class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h2 class="text-base sm:text-lg font-semibold tracking-wide">PROFILE</h2>
        <h1 class="text-3xl sm:text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-4xl sm:text-6xl">👋</span>
        </h1>
    </header>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil -->
        <div class="lg:col-span-1 bg-white rounded-2xl pb-80 border border-gray-200 shadow p-6">
            <h3 class="text-sm font-extrabold tracking-wide mb-4">PROFIL</h3>

            <div class="flex flex-col items-center mb-6">
                <div class="w-36 h-36 rounded-full bg-gray-100 border flex items-center justify-center">
                    <i class="fas fa-user text-6xl text-gray-300"></i>
                </div>
            </div>

            <dl class="text-sm">
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">STUDENT ID</dt>
                    <dd class="flex-1">: {{ $mhs->id }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">FULL NAME</dt>
                    <dd class="flex-1">: {{ $mhs->name }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">CATEGORY</dt>
                    <dd class="flex-1">: {{ $mhs->cat }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">ADDRESS</dt>
                    <dd class="flex-1">: {{ $mhs->address }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2">
                    <dt class="w-40 text-gray-600">PERSONAL EMAIL</dt>
                    <dd class="flex-1">: {{ $mhs->email }}</dd>
                </div>
            </dl>
        </div>

        <!-- Portfolio -->
        <div class="lg:col-span-2">
            <h3 class="text-sm font-extrabold tracking-wide mb-4">PORTFOLIO</h3>

            <div class="grid sm:grid-cols-2 gap-6">
                @forelse($mhs->portfolio as $p)
                    <article
                        class="bg-white rounded-xl border border-gray-200 shadow hover:shadow-md transition overflow-hidden">
                        <div class="p-3">
                            <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}"
                                class="w-full h-40 object-cover rounded-lg">
                        </div>
                        <div class="px-4 pb-4">
                            <h4 class="text-xl font-extrabold mt-1">{{ $p['title'] }}</h4>
                            <p class="italic text-gray-600 -mt-1">{{ $p['course'] }}</p>
                            <div class="mt-3 text-xs text-gray-700 flex items-center justify-between">
                                <span class="px-2 py-1 bg-gray-100 rounded">{{ $p['semester'] }}</span>
                                <button type="button" class="text-blue-600 hover:text-blue-700" title="View">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-sm text-gray-500">No portfolio yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
