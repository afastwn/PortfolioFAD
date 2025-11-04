@extends('layouts.appDosen')

@section('title', 'Profile')

@section('content')
    <!-- Header -->
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">Profile</h2>
        <h1 class="text-2xl font-extrabold flex items-center gap-2">
            Hello, {{ explode(' ', Auth::user()->name_asli)[0] ?? 'User' }}! 👋
        </h1>
    </header>

    <!-- Konten -->
    <!-- Kartu profil -->
    <div
        class="mx-auto max-w-3xl mb-20 rounded-2xl border border-gray-200 bg-white
             shadow-[0_2px_0_0_rgba(0,0,0,0.04),0_8px_20px_-10px_rgba(0,0,0,0.15)]">

        <div class="p-6 sm:p-8">
            {{-- Avatar (sesuai contohmu) --}}
            <form id="avatarFormDsn" method="POST" action="{{ route('dosen.profile.update') }}" enctype="multipart/form-data"
                class="w-full flex justify-center mb-6">
                @csrf
                <input type="file" name="photo" id="dsnAvatarInput" accept="image/*" class="hidden"
                    onchange="handleAvatarChange('dsn')">

                <div class="relative group w-32 h-32 rounded-full border bg-gray-100 flex items-center justify-center overflow-hidden cursor-pointer hover:shadow-md transition"
                    onclick="document.getElementById('dsnAvatarInput').click()" title="Click to change photo">

                    <i id="dsnUserIcon" class="fas fa-user text-5xl text-gray-300 absolute z-10 pointer-events-none"
                        style="{{ !empty(optional($user->profilDosen)->avatar_path) ? 'display:none;' : '' }}"></i>

                    <img id="dsnAvatarImg" src="{{ optional($user->profilDosen)->photo_url ?? '' }}" alt="Foto Dosen"
                        class="absolute inset-0 w-full h-full object-cover {{ empty(optional($user->profilDosen)->avatar_path) ? 'hidden' : '' }}" />

                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-sm font-semibold select-none">

                    </div>

                    <div id="dsnAvatarSpinner"
                        class="hidden absolute inset-0 bg-white/70 flex items-center justify-center rounded-full">
                        <svg class="animate-spin h-6 w-6 text-gray-600" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                </div>
            </form>


            {{-- Grid data --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-10">
                <!-- Basic Description -->
                <div>
                    <h3 class="font-semibold mb-4">Basic Description</h3>
                    <dl class="text-xs">
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">NIK</dt>
                            <dd class="flex-1">: {{ $user->nik ?? '-' }}</dd>
                        </div>
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">FULL NAME</dt>
                            <dd class="flex-1">: {{ $user->name_asli ?? '-' }}</dd>
                        </div>
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">DEPARTMENT</dt>
                            @php
                                $deptMap = [
                                    'Desain Produk' => 'Product Design',
                                    'Product Design' => 'Product Design',
                                    'Arsitektur' => 'Architecture',
                                    'Architecture' => 'Architecture',
                                ];
                                $deptDisplay = $deptMap[$profil->department ?? ''] ?? ($profil->department ?? '-');
                            @endphp
                            <dd class="flex-1">: {{ $deptDisplay }}</dd>
                        </div>
                        {{-- <div class="flex items-center gap-3 py-2">
                            <dt class="w-44 text-gray-600">ACADEMIC ADVISOR</dt>
                            <dd class="flex-1">: {{ $profil->academic_advisor ?? '-' }}</dd>
                        </div> --}}
                    </dl>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-semibold mb-4">Contact</h3>
                    <dl class="text-xs">
                        <div class="flex items-center gap-3 py-2 border-b border-gray-100">
                            <dt class="w-44 text-gray-600">PERSONAL EMAIL</dt>
                            <dd class="flex-1">: {{ $profil->personal_email ?? '-' }}</dd>
                        </div>
                        <div class="flex items-center gap-3 py-2">
                            <dt class="w-44 text-gray-600">PHONE NUMBER</dt>
                            <dd class="flex-1">: {{ $profil->phone_number ?? '-' }}</dd>
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

    {{-- ===== MODAL EDIT PROFILE (submit di bawah 2 kolom, sejajar Advisor) ===== --}}
    <div id="editModalDsn" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editModalDsn')"></div>

        <div class="absolute inset-0 flex items-center justify-center p-6">
            <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-xl overflow-y-auto"
                style="max-height: calc(100vh - 120px);">
                {{-- Header --}}
                <div class="flex items-center justify-between px-8 py-5 border-b">
                    <h2 class="text-2xl font-extrabold tracking-wide">Profile</h2>
                    <button class="p-2 rounded hover:bg-gray-100" onclick="closeModal('editModalDsn')"
                        aria-label="Close">✕</button>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('dosen.profile.update') }}" class="px-8 pt-8 pb-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-14 gap-y-6">
                        {{-- KIRI --}}
                        <div>
                            <h3 class="text-xl font-extrabold mb-6">Basic Description</h3>

                            <label class="block font-semibold mb-1">NIK</label>
                            <input name="nik" type="text" readonly
                                class="w-full h-11 rounded-lg border border-gray-300 px-3 bg-gray-100 text-gray-600 cursor-not-allowed"
                                value="{{ $user->nik ?? '-' }}" />

                            <label class="block font-semibold mt-6 mb-1">Full Name</label>
                            <input name="name_asli" type="text" readonly
                                class="w-full h-11 rounded-lg border border-gray-300 px-3 bg-gray-100 text-gray-600 cursor-not-allowed"
                                value="{{ $user->name_asli ?? '-' }}" />

                            @php
                                $deptNow = old('department', $profil->department);
                                $options = ['Product Design', 'Architecture'];
                            @endphp

                            <label class="block font-semibold mt-5 mb-1">Department</label>
                            <select name="department"
                                class="w-full h-11 rounded-lg border border-gray-300 px-3 focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Select Department --</option>

                                {{-- tampilkan nilai lama (current) jika belum ada di daftar --}}
                                @if ($deptNow && !in_array($deptNow, $options))
                                    <option value="{{ $deptNow }}" selected>(Current) {{ $deptNow }}</option>
                                @endif

                                @foreach ($options as $opt)
                                    <option value="{{ $opt }}" {{ $deptNow === $opt ? 'selected' : '' }}>
                                        {{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KANAN --}}
                        <div>
                            <h3 class="text-xl font-extrabold mb-6">Contact</h3>

                            <label class="block font-semibold mb-1">Personal Email</label>
                            <input name="personal_email" type="email"
                                class="w-full h-11 rounded-lg border border-gray-300 px-3 focus:ring-2 focus:ring-blue-500"
                                value="{{ old('personal_email', $profil->personal_email) }}" />

                            <label class="block font-semibold mt-5 mb-1">Phone Number</label>
                            <input id="phoneInput" name="phone_number" type="text"
                                class="w-full h-11 rounded-lg border border-gray-300 px-3 focus:ring-2 focus:ring-blue-500"
                                value="{{ old('phone_number', $profil->phone_number) }}" inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15" />
                            <!-- CHANGE PASSWORD -->
                            {{-- <div class="mt-8"> --}}
                            <label class="block text-base font-semibold mt-6 mb-1">Change Password</label>

                            <!-- Current Password -->
                            <div class="relative mb-3">
                                <input type="password" name="current_password" id="dsn_current_password"
                                    placeholder="Current password (required if changing)" autocomplete="current-password"
                                    class="w-full h-11 rounded-lg border border-gray-300 px-3 pr-10 focus:ring-2 focus:ring-blue-500" />
                                <button type="button" onclick="togglePassword('dsn_current_password', this)"
                                    class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <!-- New Password -->
                            <div class="relative">
                                <input type="password" name="new_password" id="dsn_new_password"
                                    placeholder="New password (leave blank to keep current)"
                                    pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                                    title="Minimal 6 karakter dan harus mengandung huruf serta angka"
                                    autocomplete="new-password"
                                    class="w-full h-11 rounded-lg border border-gray-300 px-3 pr-10 focus:ring-2 focus:ring-blue-500" />
                                <button type="button" onclick="togglePassword('dsn_new_password', this)"
                                    class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            {{-- </div> --}}


                            {{-- 🔧 Spacer untuk menyamakan baris dengan "Departement" di kolom kiri --}}
                            <div class="mt-5 hidden lg:block">
                                <label class="block font-semibold mb-1 opacity-0 select-none">Spacer</label>
                                <div class="h-11"></div>
                            </div>

                            {{-- ✅ Tombol sekarang sejajar dengan "Academic Advisor" di kiri --}}
                            <div class="mt-(-40) flex xl:justify-end justify-end">
                                <button type="submit"
                                    class="px-48 h-11 rounded-xl bg-blue-600 text-white font-bold tracking-wide hover:brightness-110 active:brightness-95">
                                    SUBMIT
                                </button>
                            </div>
                        </div>

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

    <script>
        function handleAvatarChange(prefix) {
            const input = document.getElementById(prefix + 'AvatarInput');
            const img = document.getElementById(prefix + 'AvatarImg');
            const icon = document.getElementById(prefix + 'UserIcon');
            const spinner = document.getElementById(prefix + 'AvatarSpinner');
            const form = document.getElementById('avatarForm' + prefix.charAt(0).toUpperCase() + prefix.slice(1));

            const file = input.files && input.files[0];
            if (!file) return;

            img.src = URL.createObjectURL(file);
            img.classList.remove('hidden');
            icon.style.display = 'none';

            spinner.classList.remove('hidden');
            form.submit();
        }
    </script>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>

@endsection
