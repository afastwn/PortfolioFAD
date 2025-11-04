@extends('layouts.appMhs')

@section('title', 'Profile')

@section('content')
    {{-- Header --}}
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">Profile</h2>
        <h1 class="text-2xl font-extrabold flex items-center gap-2">
            Hello, {{ explode(' ', Auth::user()->name_asli)[0] ?? 'User' }}! 👋
        </h1>
    </header>

    {{-- Grid 2 kolom: center, gap kecil, profil span 3 baris --}}
    <div class="px-4">
        <div class="grid w-full max-w-3xl mx-auto gap-6
                   grid-cols-1 lg:grid-cols-2 lg:auto-rows-max">

            {{-- Kolom kiri: Profil (span 3 baris agar setinggi kolom kanan) --}}
            <section class="lg:row-span-3">
                <div class="bg-white rounded-xl border shadow p-6 h-full flex flex-col h-fit">
                    <h3 class="font-extrabold mb-4">PROFIL</h3>

                    {{-- Avatar klik = upload + auto-submit --}}
                    <form id="avatarFormMhs" method="POST" action="{{ route('mhs.profile.save') }}"
                        enctype="multipart/form-data" class="w-full flex justify-center mb-6">
                        @csrf
                        <input type="file" name="photo" id="mhsAvatarInput" accept="image/*" class="hidden"
                            onchange="handleAvatarChange('mhs')">

                        <div class="relative group w-32 h-32 rounded-full border bg-gray-100 flex items-center justify-center overflow-hidden cursor-pointer hover:shadow-md transition"
                            onclick="document.getElementById('mhsAvatarInput').click()" title="Click to change photo">

                            {{-- Ikon default --}}
                            <i id="mhsUserIcon" class="fas fa-user text-5xl text-gray-300 absolute z-10 pointer-events-none"
                                style="{{ !empty($profile->photo) ? 'display:none;' : '' }}"></i>

                            {{-- Foto Profil --}}
                            <img id="mhsAvatarImg" src="{{ $profile->photo_url ?? '' }}" alt="Foto Profil"
                                class="absolute inset-0 w-full h-full object-cover {{ empty($profile->photo) ? 'hidden' : '' }}" />

                            {{-- Overlay hover --}}
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-sm font-semibold select-none">
                            </div>

                            {{-- Spinner --}}
                            <div id="mhsAvatarSpinner"
                                class="hidden absolute inset-0 bg-white/70 flex items-center justify-center rounded-full">
                                <svg class="animate-spin h-6 w-6 text-gray-600" viewBox="0 0 24 24" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </form>

                    {{-- Detail Profile --}}
                    <dl class="text-sm">
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">STUDENT ID</dt>
                            <dd class="inline-block -ml-7">: {{ $user->nim ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">FULL NAME</dt>
                            <dd class="inline-block -ml-7">: {{ $user->name_asli ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">PHONE</dt>
                            <dd class="inline-block -ml-7">: {{ $profile->phone ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">ADDRESS</dt>
                            <dd class="inline-block -ml-7">: {{ $profile->address ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">EMAIL</dt>
                            <dd class="inline-block -ml-7">: {{ $profile->email_pribadi ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2">
                            <dt class="text-gray-500">MOTIVATION</dt>
                            <dd class="inline-block -ml-7">: {{ $profile->motivation ?? '-' }}</dd>
                        </div>
                    </dl>


                    {{-- Tags --}}
                    {{-- Tags (render only if exists) --}}
                    @php $tags = is_array($profile->tags ?? null) ? $profile->tags : []; @endphp
                    @if (count($tags))
                        <div class="mt-4 pt-4 border-t flex gap-2 flex-wrap justify-center">
                            @foreach ($tags as $t)
                                <span
                                    class="px-7 py-1 text-xs font-semibold bg-blue-700 text-white rounded">{{ $t }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Tombol edit (tetap di bawah tag biru, bukan absolute) --}}
                    <div class="mt-4 flex justify-end">
                        <button class="text-blue-600 hover:text-blue-800" title="Edit profile"
                            onclick="openModal('editProfileModal')">
                            <i class="fas fa-pen"></i>
                        </button>
                    </div>
                </div>
            </section>

            {{-- Kolom kanan --}}
            <section class="lg:row-span-3 space-y-6">
                {{-- CAMPUS ACTIVITIES --}}
                <div class="bg-white rounded-xl border shadow p-6">
                    <h3 class="font-extrabold mb-4">CAMPUS ACTIVITIES</h3>
                    <ul class="space-y-2 text-sm">
                        @forelse ($activities as $a)
                            <li class="flex items-center gap-2">
                                <i class="far fa-check-square text-blue-600"></i>
                                <span>{{ $a->activity }}</span>
                            </li>
                        @empty
                            <li class="text-gray-500">No activities yet.</li>
                        @endforelse
                    </ul>
                    <div class="mt-4 flex justify-end">
                        <button class="text-blue-600 hover:text-blue-800" onclick="openModal('editActivitiesModal')">
                            <i class="fas fa-pen"></i>
                        </button>
                    </div>
                </div>

                {{-- SKILLS --}}
                <div class="bg-white rounded-xl border shadow p-6">
                    <h3 class="font-extrabold mb-4">SKILLS</h3>
                    <ul class="space-y-2 text-sm">
                        @forelse ($skills as $s)
                            <li class="flex items-center gap-2">
                                <i class="far fa-check-square text-blue-600"></i>
                                <span>{{ $s->skill }}</span>
                            </li>
                        @empty
                            <li class="text-gray-500">No skills yet.</li>
                        @endforelse
                    </ul>
                    <div class="mt-4 flex justify-end">
                        <button class="text-blue-600 hover:text-blue-800" onclick="openModal('editSkillsModal')">
                            <i class="fas fa-pen"></i>
                        </button>
                    </div>
                </div>


                {{-- SCHOOL --}}
                <div class="bg-white rounded-xl border shadow p-6">
                    <h3 class="font-extrabold mb-4">SCHOOL</h3>
                    <div class="text-sm space-y-1">
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <span class="text-gray-500">SCHOOL ORIGIN</span><span>:
                                {{ $school->school_origin ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <span class="text-gray-500">PROVINCE</span><span>: {{ $school->province ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <span class="text-gray-500">REGENCY</span><span>: {{ $school->regency ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <span class="text-gray-500">CITY</span><span>: {{ $school->city ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2">
                            <span class="text-gray-500">LEVEL</span><span>: {{ $school->level ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button class="text-blue-600 hover:text-blue-800" title="Edit school"
                            onclick="openModal('editSchoolModal')">
                            <i class="fas fa-pen"></i>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- ===== MODAL EDIT PROFILE (overlay) ===== --}}
    <div id="editProfileModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editProfileModal')"></div>

        {{-- Center wrapper --}}
        <div class="absolute inset-0 flex items-center justify-center overflow-y-auto p-4">
            <div
                class="w-full max-w-5xl bg-white shadow-lg rounded-lg my-10 md:my-16 max-h-[90vh] overflow-y-auto border border-gray-200">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b sticky top-0 bg-white z-10">
                    <h3 class="text-2xl font-extrabold">PROFILE</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editProfileModal')">✕</button>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('mhs.profile.save') }}" class="px-6 py-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- LEFT COLUMN --}}
                        <div class="space-y-5">
                            <div>
                                <label class="block text-base font-semibold mb-1">Student ID</label>
                                <input type="text" readonly value="{{ $user->nim }}"
                                    class="w-full h-11 rounded-lg border px-3 bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-base font-semibold mb-1">Full Name</label>
                                <input type="text" readonly value="{{ $user->name_asli }}"
                                    class="w-full h-11 rounded-lg border px-3 bg-gray-100">
                            </div>

                            <div>
                                <label class="block text-base font-semibold mb-1">Phone Number</label>
                                <input name="phone" value="{{ old('phone', $profile->phone) }}"
                                    placeholder="e.g. 0812xxxxxxx" class="w-full h-11 rounded-lg border px-3"
                                    inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    maxlength="15">
                            </div>

                            <div>
                                <label class="block text-base font-semibold mb-1">Address</label>
                                <input name="address" value="{{ old('address', $profile->address) }}"
                                    placeholder="Street / District / City" class="w-full h-11 rounded-lg border px-3">
                            </div>

                            <div>
                                <label class="block text-base font-semibold mb-1">Personal Email</label>
                                <input type="email" name="email_pribadi"
                                    value="{{ old('email_pribadi', $profile->email_pribadi) }}"
                                    placeholder="yourname@email.com" class="w-full h-11 rounded-lg border px-3">
                            </div>

                            <!-- CHANGE PASSWORD -->
                            <div>
                                <label class="block text-base font-semibold mb-1">Change Password</label>

                                <!-- Current Password -->
                                <div class="relative mb-3">
                                    <input type="password" name="current_password" id="current_password"
                                        placeholder="Current password (required if changing)"
                                        autocomplete="current-password"
                                        class="w-full h-11 rounded-lg border border-gray-300 px-3 pr-10 focus:ring-2 focus:ring-blue-500" />
                                    <button type="button" onclick="togglePassword('current_password', this)"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <!-- New Password -->
                                <div class="relative">
                                    <input type="password" name="new_password" id="new_password"
                                        placeholder="New password (leave blank to keep current)"
                                        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                                        title="Minimal 6 karakter dan harus mengandung huruf serta angka"
                                        autocomplete="new-password"
                                        class="w-full h-11 rounded-lg border border-gray-300 px-3 pr-10 focus:ring-2 focus:ring-blue-500" />
                                    <button type="button" onclick="togglePassword('new_password', this)"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xl font-semibold mb-1">Motivation and Problem-Solving</label>
                                <p class="text-sm text-gray-500 mb-2">
                                    Describe your motivation and how you solve problems
                                </p>
                                <textarea name="motivation" class="w-full min-h-[170px] rounded-lg border px-3 py-2"
                                    placeholder="Tell us about your motivation and how you approach problems...">{{ old('motivation', $profile->motivation) }}</textarea>
                            </div>

                            {{-- Tags bebas (maksimal 3) --}}
                            @php $tags = is_array(old('tags', $profile->tags ?? [])) ? old('tags', $profile->tags ?? []) : []; @endphp
                            <div>
                                <label class="block text-xl font-semibold mb-2">Describe Yourself in 3 Words</label>

                                <div id="tagsWrap" class="flex flex-wrap gap-2">
                                    @foreach ($tags as $i => $t)
                                        <div class="flex items-center gap-2 border rounded px-2 py-1">
                                            <input name="tags[]" value="{{ $t }}" maxlength="20"
                                                class="border-none focus:ring-0 p-0 text-sm w-32" />
                                            <button type="button" class="text-gray-500 hover:text-red-600"
                                                onclick="this.parentElement.remove(); updateTagBtn();">×</button>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" id="addTagBtn"
                                    class="mt-3 px-4 py-2 rounded-lg bg-blue-100 text-blue-600 font-semibold"
                                    onclick="addTagInput()">+ Add</button>

                                <p class="text-xs text-gray-500 mt-2">Max 3 items, each up to 20 characters.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-8 flex justify-center">
                        <button
                            class="w-72 h-12 rounded-md bg-blue-600 text-white text-lg font-extrabold tracking-wide hover:bg-blue-700">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}

    @if ($errors->has('current_password') || $errors->has('new_password'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Munculkan dialog
                var msg =
                    @json($errors->first('current_password') ?: $errors->first('new_password'));
                alert(msg);

                // Jika kamu pakai modal bernama 'editProfileModal', buka kembali
                if (typeof openModal === 'function') {
                    openModal('editProfileModal');
                }
            });
        </script>
    @endif
    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>


    {{-- Script untuk tambah/hapus tag (maks 3) --}}
    <script>
        function addTagInput() {
            const wrap = document.getElementById('tagsWrap');
            if (wrap.children.length >= 3) return;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 border rounded px-2 py-1';
            div.innerHTML = `
      <input name="tags[]" maxlength="20"
             class="border-none focus:ring-0 p-0 text-sm w-32" placeholder="Word">
      <button type="button" class="text-gray-500 hover:text-red-600"
              onclick="this.parentElement.remove(); updateTagBtn();">×</button>
    `;
            wrap.appendChild(div);
            updateTagBtn();
        }

        function updateTagBtn() {
            const wrap = document.getElementById('tagsWrap');
            const btn = document.getElementById('addTagBtn');
            btn.disabled = wrap.children.length >= 3;
            btn.classList.toggle('opacity-50', btn.disabled);
            btn.classList.toggle('cursor-not-allowed', btn.disabled);
        }
        document.addEventListener('DOMContentLoaded', updateTagBtn);
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


    {{-- ===== Script modal (vanilla JS) ===== --}}
    <script>
        // gunakan penanda modal aktif
        window.__currentModal = window.__currentModal || null;

        function openModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            window.__currentModal = id; // simpan modal aktif
            document.addEventListener('keydown', escHandler); // ESC to close
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (window.__currentModal === id) window.__currentModal = null;
            document.removeEventListener('keydown', escHandler);
        }

        function escHandler(e) {
            // tutup modal yang sedang aktif
            if (e.key === 'Escape' && window.__currentModal) {
                closeModal(window.__currentModal);
            }
        }
    </script>

    {{-- ===================== MODAL CAMPUS ACTIVITIES ===================== --}}
    <div id="editActivitiesModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editActivitiesModal')"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <!-- container modal: max height viewport, kolom, overflow hidden -->
            <div
                class="w-full max-w-sm max-h-[90vh] bg-white rounded-2xl shadow-lg
            flex flex-col overflow-hidden min-h-0">


                <!-- HEADER (tetap) -->
                <div class="px-6 py-4 border-b bg-white sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-extrabold">CAMPUS ACTIVITIES</h3>
                        <button class="p-1.5 rounded hover:bg-gray-100"
                            onclick="closeModal('editActivitiesModal')">✕</button>
                    </div>
                </div>

                <form method="POST" action="{{ route('mhs.profile.activities') }}"
                    class="flex-1 flex flex-col min-h-0">
                    @csrf
                    @php
                        // Opsi bawaan
                        $defaults = [
                            'Teaching Assistant',
                            'Laboratory Volunteer',
                            'Campus Unit Volunteer',
                            'Campus Event Committee',
                            'Student Organization Member',
                        ];

                        // Data existing dari DB (Collection -> array)
                        $actArr = ($activities ?? collect())->pluck('activity')->values()->all();

                        // Pisahkan default yang perlu dicentang vs custom
                        $checkedDefaults = array_intersect($actArr, $defaults);
                        $customActs = array_values(array_diff($actArr, $defaults));
                    @endphp

                    <!-- BODY (scroll) -->
                    <div id="actsBody" class="px-6 py-6 space-y-4 overflow-y-auto flex-1 min-h-0">
                        {{-- Daftar default (checkbox saja) --}}
                        <div class="space-y-4 text-lg">
                            @foreach ($defaults as $label)
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" name="activities[]" value="{{ $label }}"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                        {{ in_array($label, $checkedDefaults) ? 'checked' : '' }}>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>

                        {{-- Custom rows yang sudah ada di DB --}}
                        <div id="actsCustomWrap" class="space-y-4 text-lg">
                            @foreach ($customActs as $txt)
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 act-toggle"
                                        checked>
                                    <input type="text" name="activities[]" value="{{ $txt }}"
                                        maxlength="50"
                                        class="flex-1 h-10 rounded-lg border border-gray-300 px-3 text-base act-input">
                                </div>
                            @endforeach
                        </div>

                        {{-- Others / Add --}}
                        <button type="button" class="mt-1 text-gray-500 underline underline-offset-4"
                            onclick="addActivityRow()">Others / Add</button>
                    </div>

                    <!-- FOOTER (tetap) -->
                    <div class="px-6 py-4 border-t bg-white sticky bottom-0 z-10">
                        <div class="flex justify-center">
                            <button
                                class="w-64 h-11 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                                SUBMIT
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================== /MODAL CAMPUS ACTIVITIES ===================== --}}

    {{-- Script kecil --}}
    <script>
        function wireActRow(row) {
            const cb = row.querySelector('.act-toggle');
            const input = row.querySelector('.act-input');
            const sync = () => {
                input.disabled = !cb.checked;
            };
            cb.addEventListener('change', sync);
            sync();
        }

        function addActivityRow() {
            const wrap = document.getElementById('actsCustomWrap');
            const row = document.createElement('div');
            row.className = 'flex items-center gap-3 mt-4';
            row.innerHTML = `
  <input type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 act-toggle" checked>
  <input type="text" name="activities[]" maxlength="50"
         class="flex-1 h-10 rounded-lg border border-gray-300 px-3 text-base act-input"
         placeholder="Type your activity">
`;
            wrap.appendChild(row);
            wireActRow(row);

            // auto scroll ke bawah agar field baru terlihat
            const body = document.getElementById('actsBody');
            if (body) body.scrollTo({
                top: body.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Wire existing custom rows on load
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#actsCustomWrap > div').forEach(wireActRow);
        });
    </script>


    {{-- ===================== MODAL SKILLS ===================== --}}
    <div id="editSkillsModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editSkillsModal')"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <!-- container modal: max height viewport, kolom, overflow hidden -->
            <div
                class="w-full max-w-sm max-h-[90vh] bg-white rounded-2xl shadow-lg
            flex flex-col overflow-hidden min-h-0">

                <!-- HEADER (tetap) -->
                <div class="px-6 py-4 border-b bg-white sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-extrabold">SKILLS</h3>
                        <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editSkillsModal')">✕</button>
                    </div>
                </div>

                <form method="POST" action="{{ route('mhs.profile.skills') }}" class="flex-1 flex flex-col min-h-0">
                    @csrf
                    @php
                        // Opsi default
                        $skillDefaults = ['Adobe Photoshop', 'Corel Draw', 'Blender', 'AutoCAD', 'Adobe Illustrator'];

                        // Data existing dari DB → pisahkan default vs custom
                        $skillArr = ($skills ?? collect())->pluck('skill')->values()->all();
                        $checkedDefaultSkills = array_intersect($skillArr, $skillDefaults);
                        $customSkills = array_values(array_diff($skillArr, $skillDefaults));
                    @endphp

                    <!-- BODY (scroll) -->
                    <div id="skillsBody" class="px-6 py-6 space-y-4 overflow-y-auto flex-1 min-h-0">
                        {{-- Checkbox default --}}
                        <div class="space-y-4 text-lg">
                            @foreach ($skillDefaults as $label)
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" name="skills[]" value="{{ $label }}"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                        {{ in_array($label, $checkedDefaultSkills) ? 'checked' : '' }}>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>

                        {{-- Rows custom yang sudah ada --}}
                        <div id="skillsCustomWrap" class="space-y-4 text-lg">
                            @foreach ($customSkills as $txt)
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 skill-toggle"
                                        checked>
                                    <input type="text" name="skills[]" value="{{ $txt }}" maxlength="40"
                                        class="flex-1 h-10 rounded-lg border border-gray-300 px-3 text-base skill-input">
                                </div>
                            @endforeach
                        </div>

                        {{-- Others / Add --}}
                        <button type="button" class="mt-1 text-gray-500 underline underline-offset-4"
                            onclick="addSkillRow()">Others / Add</button>
                    </div>

                    <!-- FOOTER (tetap) -->
                    <div class="px-6 py-4 border-t bg-white sticky bottom-0 z-10">
                        <div class="flex justify-center">
                            <button
                                class="w-64 h-11 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                                SUBMIT
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================== /MODAL SKILLS ===================== --}}

    {{-- Script kecil (boleh ditaruh sekali di akhir halaman) --}}
    <script>
        function wireSkillRow(row) {
            const cb = row.querySelector('.skill-toggle');
            const input = row.querySelector('.skill-input');
            const sync = () => {
                input.disabled = !cb.checked;
            };
            cb.addEventListener('change', sync);
            sync();
        }

        function addSkillRow() {
            const wrap = document.getElementById('skillsCustomWrap');
            const row = document.createElement('div');
            row.className = 'flex items-center gap-3 mt-4';
            row.innerHTML = `
  <input type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 skill-toggle" checked>
  <input type="text" name="skills[]" maxlength="40"
         class="flex-1 h-10 rounded-lg border border-gray-300 px-3 text-base skill-input"
         placeholder="Type your skill">
`;
            wrap.appendChild(row);
            wireSkillRow(row);

            // auto scroll ke bawah agar field baru terlihat
            const body = document.getElementById('skillsBody');
            if (body) body.scrollTo({
                top: body.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Inisialisasi untuk rows custom yang sudah ada
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#skillsCustomWrap > div').forEach(wireSkillRow);
        });
    </script>

    {{-- ===== MODAL SCHOOL ===== --}}
    <div id="editSchoolModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editSchoolModal')"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-3xl bg-white shadow-lg">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-2xl font-extrabold">SCHOOL</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editSchoolModal')"
                        aria-label="Close">✕</button>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('mhs.profile.school') }}" class="px-6 py-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kiri --}}
                        <div class="space-y-5">
                            <div>
                                <label class="block text-lg font-semibold mb-1">School Origin</label>
                                <input type="text" name="school_origin"
                                    value="{{ old('school_origin', $school->school_origin) }}"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            {{-- Province --}}
                            <div>
                                <label class="block text-lg font-semibold mb-1">Province</label>
                                <select id="provinceSel" name="province_id"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                    <option value="">-- Select Province --</option>
                                </select>
                            </div>

                            {{-- Regency (Kabupaten) --}}
                            <div>
                                <label class="block text-lg font-semibold mb-1">Regency</label>
                                <select id="regencySel" name="regency_id"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed">
                                    <option value="">-- Select Regency --</option>
                                </select>
                            </div>
                        </div>

                        {{-- Kanan --}}
                        <div class="space-y-5">
                            {{-- City (Kota) --}}
                            <div>
                                <label class="block text-lg font-semibold mb-1">City</label>
                                <select id="citySel" name="city_id"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed">
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>

                            {{-- Level: pilih salah satu --}}
                            <div class="pt-1">
                                <label class="flex items-center gap-3 text-base mb-2">
                                    <input type="radio" name="level" value="SMA"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                        {{ old('level', $school->level) === 'SMA' ? 'checked' : '' }}>
                                    <span>SMA</span>
                                </label>
                                <label class="flex items-center gap-3 text-base">
                                    <input type="radio" name="level" value="SMK"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                        {{ old('level', $school->level) === 'SMK' ? 'checked' : '' }}>
                                    <span>SMK</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-8 flex justify-center">
                        <button type="submit"
                            class="w-64 h-11 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}

    <script>
        (async function() {
            const provSel = document.getElementById('provinceSel');
            const regSel = document.getElementById('regencySel');
            const citySel = document.getElementById('citySel');

            // Prefill (jika user sudah punya data)
            const PREV = {
                province: @json(old('province', $school->province ?? null)),
                regencyId: @json($school->cityRef && $school->cityRef->type === 'KAB' ? $school->cityRef->id : null),
                cityId: @json($school->cityRef && $school->cityRef->type === 'KOTA' ? $school->cityRef->id : null),
                provinceIdGuess: null,
            };

            // Helper: enable/disable + clear lawannya saat dipilih
            function syncMutualDisable() {
                const regPicked = regSel.value !== '';
                const cityPicked = citySel.value !== '';

                if (regPicked && !regSel.disabled) {
                    // Kunci city
                    citySel.value = '';
                    citySel.disabled = true;
                } else if (!regPicked && !cityPicked) {
                    // Tidak ada yang dipilih → dua-duanya aktif
                    citySel.disabled = false;
                }

                if (cityPicked && !citySel.disabled) {
                    // Kunci regency
                    regSel.value = '';
                    regSel.disabled = true;
                } else if (!cityPicked && !regPicked) {
                    // Tidak ada yang dipilih → dua-duanya aktif
                    regSel.disabled = false;
                }
            }

            // Reset keduanya saat province berubah
            function resetDistricts() {
                regSel.innerHTML = `<option value="">-- Select Regency --</option>`;
                citySel.innerHTML = `<option value="">-- Select City --</option>`;
                regSel.disabled = false;
                citySel.disabled = false;
            }

            // Loaders
            async function loadRegencies(pid) {
                regSel.innerHTML = `<option value="">-- Select Regency --</option>`;
                if (!pid) return;
                const items = await fetch(`{{ route('loc.regencies') }}?province_id=${pid}`).then(r => r
                .json());
                regSel.innerHTML += items.map(x => `<option value="${x.id}">${x.name}</option>`).join('');
            }
            async function loadCities(pid) {
                citySel.innerHTML = `<option value="">-- Select City --</option>`;
                if (!pid) return;
                const items = await fetch(`{{ route('loc.cities') }}?province_id=${pid}`).then(r => r.json());
                citySel.innerHTML += items.map(x => `<option value="${x.id}">${x.name}</option>`).join('');
            }

            // 1) Load provinces
            const provinces = await fetch('{{ route('loc.provinces') }}').then(r => r.json());
            provSel.innerHTML = `<option value="">-- Select Province --</option>` +
                provinces.map(p => `<option value="${p.province_id}">${p.province}</option>`).join('');

            // pilih province berdasarkan nama lama (jika ada)
            if (PREV.province) {
                const hit = provinces.find(p => p.province === PREV.province);
                if (hit) {
                    provSel.value = hit.province_id;
                    PREV.provinceIdGuess = hit.province_id;
                }
            }

            // Event: province berubah → muat ulang & reset mutual
            provSel.addEventListener('change', async (e) => {
                const pid = e.target.value;
                resetDistricts();
                await Promise.all([loadRegencies(pid), loadCities(pid)]);
                // setelah reload, pastikan tidak ada yang terkunci
                regSel.disabled = false;
                citySel.disabled = false;
            });

            // Event: regency/city berubah → jaga mutual exclusivity
            regSel.addEventListener('change', syncMutualDisable);
            citySel.addEventListener('change', syncMutualDisable);

            // Prefill detail setelah province tertebak
            if (PREV.provinceIdGuess) {
                await Promise.all([loadRegencies(PREV.provinceIdGuess), loadCities(PREV.provinceIdGuess)]);
                if (PREV.regencyId) {
                    regSel.value = PREV.regencyId;
                }
                if (PREV.cityId) {
                    citySel.value = PREV.cityId;
                }
                // Terapkan aturan eksklusif berdasar prefill
                syncMutualDisable();
            }
        })();
    </script>



    <script>
        // modal helpers (blok keduanya tetap dipertahankan, implementasi diselaraskan)
        window.__currentModal = window.__currentModal || null;

        function openModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            window.__currentModal = id;
            document.addEventListener('keydown', escHandler);
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (window.__currentModal === id) window.__currentModal = null;
            document.removeEventListener('keydown', escHandler);
        }

        function escHandler(e) {
            if (e.key === 'Escape' && window.__currentModal) {
                closeModal(window.__currentModal);
            }
        }

        // Tambah baris "Others": checkbox + input (tanpa remove)
        // listId = id container; adderId = id checkbox pemicu
        function addOtherField(listId, adderId) {
            const adder = document.getElementById(adderId);
            if (!adder.checked) return;

            const list = document.getElementById(listId);
            const nameAttr = list?.dataset?.name || 'others[]';

            const row = document.createElement('div');
            row.className = 'flex items-center gap-3';

            const cb = document.createElement('input');
            cb.type = 'checkbox';
            cb.name = nameAttr;
            cb.className = 'h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 disabled:opacity-50';
            cb.disabled = true; // aktif otomatis saat ada teks

            const input = document.createElement('input');
            input.type = 'text';
            input.placeholder = 'Type other...';
            input.className = 'flex-1 h-9 rounded-md border border-gray-300 px-3 text-sm';

            // sinkron nilai checkbox
            input.addEventListener('input', () => {
                const v = input.value.trim();
                cb.value = v;
                cb.disabled = v.length === 0;
            });

            row.append(cb, input);
            list.appendChild(row);

            // reset adder agar bisa tambah lagi
            adder.checked = false;
            input.focus();
        }
    </script>



@endsection
