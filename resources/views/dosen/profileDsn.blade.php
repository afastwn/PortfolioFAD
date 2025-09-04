@extends('layouts.appDosen')

@section('title', 'Profile')

@section('content')
    <!-- Header -->
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">Profile</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    <!-- Konten -->
    <!-- Kartu profil -->
    <div
        class="mx-auto max-w-3xl mb-20 rounded-2xl border border-gray-200 bg-white
             shadow-[0_2px_0_0_rgba(0,0,0,0.04),0_8px_20px_-10px_rgba(0,0,0,0.15)]">

        <div class="p-6 sm:p-8">
            {{-- Avatar (sesuai contohmu) --}}
            <div class="w-full flex justify-center mb-6">
                <div class="w-32 h-32 rounded-full bg-gray-100 border flex items-center justify-center">
                    <i class="fas fa-user text-5xl text-gray-300"></i>
                </div>
            </div>

            {{-- Grid data --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-10">
                <!-- Basic Description -->
                <div>
                    <h3 class="font-semibold mb-4">Basic Description</h3>
                    <dl class="text-sm">
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">NIP/NIPD</dt>
                            <dd class="flex-1">: {{ $dosen->nip ?? '72220525' }}</dd>
                        </div>
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">FULL NAME</dt>
                            <dd class="flex-1">: {{ $dosen->name ?? 'Filistera Santoso' }}</dd>
                        </div>
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">DEPARTEMENT</dt>
                            <dd class="flex-1">: {{ $dosen->department ?? 'Desain Produk' }}</dd>
                        </div>
                        <div class="flex items-center gap-3 py-2">
                            <dt class="w-44 text-gray-600">ACADEMIC ADVISOR</dt>
                            <dd class="flex-1">: {{ $dosen->angkatan ?? '2022' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold mb-4">Contact</h3>
                    <dl class="text-sm">
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">PERSONAL EMAIL</dt>
                            <dd class="flex-1">: {{ $dosen->email ?? '@123' }}</dd>
                        </div>
                        <div class="flex items-center gap-3 py-2">
                            <dt class="w-44 text-gray-600">PHONE NUMBER</dt>
                            <dd class="flex-1">: {{ $dosen->phone ?? '12345' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Tombol edit: icon pensil biru kanan-bawah --}}
        <div class="relative">
            <button type="button" onclick="openModal('editModalDsn')"
                class="absolute right-4 bottom-4 text-blue-600 hover:text-blue-700" aria-label="Edit profile">
                <i class="fas fa-pen"></i>
            </button>
        </div>
    </div>

    {{-- ===== MODAL EDIT PROFILE (overlay) – versi DOSEN ===== --}}
    <div id="editModalDsn" class="fixed inset-0 z-[100] hidden">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editModalDsn')"></div>

        {{-- Wrapper flex untuk center --}}
        <div class="absolute inset-0 flex items-center justify-center p-4">
            {{-- Dialog --}}
            <div class="w-full max-w-5xl min-h-[350px] bg-white shadow-lg overflow-hidden">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h2 class="text-xl font-extrabold tracking-wide">Edit Profile</h2>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editModalDsn')"
                        aria-label="Close">✕</button>
                </div>

                {{-- Body: form (dummy, UI/UX saja) --}}
                <form method="GET" action="/profileDsn" class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        {{-- Kolom kiri: Basic Description --}}
                        <div>
                            <h4 class="font-semibold text-lg mb-4">Basic Description</h4>

                            <label class="block font-semibold mb-2">NIP/NIPD</label>
                            <input type="text"
                                class="w-full h-12 px-4 rounded-lg border border-gray-300
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $dosen->nip ?? '72220525' }}" />

                            <label class="block font-semibold mt-6 mb-2">Full Name</label>
                            <input type="text"
                                class="w-full h-12 px-4 rounded-lg border border-gray-300
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $dosen->name ?? 'Filistera Santoso' }}" />

                            <label class="block font-semibold mt-6 mb-2">Departement</label>
                            <input type="text"
                                class="w-full h-12 px-4 rounded-lg border border-gray-300
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $dosen->department ?? 'Desain Produk' }}" />

                            <label class="block font-semibold mt-6 mb-2">Academic Advisor</label>
                            <input type="text"
                                class="w-full h-12 px-4 rounded-lg border border-gray-300
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $dosen->angkatan ?? '2022' }}" />
                        </div>

                        {{-- Kolom kanan: Contact --}}
                        <div>
                            <h4 class="font-semibold text-lg mb-4">Contact</h4>

                            <label class="block font-semibold mb-2">Personal Email</label>
                            <input type="email"
                                class="w-full h-12 px-4 rounded-lg border border-gray-300
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $dosen->email ?? '@123' }}" />

                            <label class="block font-semibold mt-6 mb-2">Phone Number</label>
                            <input type="text"
                                class="w-full h-12 px-4 rounded-lg border border-gray-300
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $dosen->phone ?? '12345' }}" />
                        </div>
                    </div>

                    {{-- Footer: Submit (dummy, reload halaman) --}}
                    <div class="mt-10 flex justify-end">
                        <button type="submit"
                            class="px-10 h-12 rounded-xl bg-[#2F62F5] text-white font-extrabold tracking-wide
                         hover:brightness-110 active:brightness-95">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}

    {{-- ===== Script modal (vanilla JS) – khusus modal ini ===== --}}
    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            // ESC to close
            document.addEventListener('keydown', escHandler);
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            document.removeEventListener('keydown', escHandler);
        }

        function escHandler(e) {
            if (e.key === 'Escape') closeModal('editModalDsn');
        }
    </script>
@endsection
