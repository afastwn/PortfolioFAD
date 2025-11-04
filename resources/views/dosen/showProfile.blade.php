@extends('layouts.appDosen')

@section('title', 'Profile')

@section('content')
    <header class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h2 class="text-base sm:text-lg font-semibold tracking-wide">PROFILE</h2>
        <h1 class="text-2xl font-extrabold flex items-center gap-2">
            Hello, {{ explode(' ', Auth::user()->name_asli)[0] ?? 'User' }}! 👋
        </h1>
    </header>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil -->
        <div class="lg:col-span-1 bg-white rounded-2xl pb-80 border border-gray-200 shadow p-6">
            <h3 class="text-sm font-extrabold tracking-wide mb-4">PROFIL</h3>

            <div class="flex flex-col items-center mb-6">
                <div class="w-36 h-36 rounded-full bg-gray-100 border flex items-center justify-center overflow-hidden">
                    @if (!empty($avatarUrl))
                        <img src="{{ $avatarUrl }}" alt="{{ $user->name_asli }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user text-6xl text-gray-300"></i>
                    @endif
                </div>

            </div>

            <dl class="text-sm">
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">STUDENT ID</dt>
                    <dd class="flex-1 -ml-8">: {{ $user->nim ?? $user->id }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">FULL NAME</dt>
                    <dd class="flex-1 -ml-8">: {{ $user->name_asli }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">CATEGORIES</dt>
                    <dd class="flex-1 -ml-8">: {{ $categoriesText }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">ADDRESS</dt>
                    <dd class="flex-1 -ml-8">: {{ $profile->address ?? '-' }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                    <dt class="w-40 text-gray-600">PHONE</dt>
                    <dd class="flex-1 -ml-8">: {{ $profile->phone ?? '-' }}</dd>
                </div>
                <div class="flex items-center gap-3 py-2">
                    <dt class="w-40 text-gray-600">PERSONAL EMAIL</dt>
                    <dd class="flex-1 -ml-8">: {{ $profile->email_pribadi ?? '-' }}</dd>
                </div>
            </dl>

            </dl>
        </div>

        <!-- Portfolio -->
        <div class="lg:col-span-2">
            <h3 class="text-sm font-extrabold tracking-wide mb-4">PORTFOLIO</h3>

            <div class="grid sm:grid-cols-2 gap-6">
                @forelse($projects as $p)
                    <article
                        class="relative bg-white rounded-xl border border-gray-200 shadow hover:shadow-md transition overflow-hidden">
                        <div class="p-3">
                            <img src="{{ $p->display_cover_url ?? asset('images/placeholder-project.jpg') }}"
                                alt="{{ $p->title }}" class="w-full h-40 object-cover rounded-lg">
                        </div>
                        <div class="px-4 pb-10"> {{-- beri ruang untuk tombol bawah --}}
                            <h4 class="text-xl font-extrabold mt-1">{{ $p->title }}</h4>
                            <p class="italic text-gray-600 -mt-1">{{ $p->course ?? '—' }}</p>
                            <div class="mt-3 text-xs text-gray-700 flex items-center justify-between">
                                <span class="px-2 py-1 bg-gray-100 rounded">
                                    {{ $p->semester ? 'Semester ' . $p->semester : '—' }}
                                </span>
                            </div>
                        </div>

                        {{-- tombol mata di pojok kanan bawah --}}
                        <a href="{{ route('dosen.projects.view', $p->id) }}"
                            class="absolute bottom-3 right-3 inline-flex items-center justify-center w-8 h-8 rounded-full border bg-white shadow hover:bg-gray-50"
                            title="View">
                            <i class="far fa-eye"></i>
                        </a>
                    </article>

                @empty
                    <div class="col-span-full text-sm text-gray-500">No portfolio yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
