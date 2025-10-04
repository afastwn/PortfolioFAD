@extends('layouts.appMhs')

@section('title', 'Profile')

@section('content')
    {{-- Header --}}
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">Profile</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    {{-- Grid 2 kolom: center, gap kecil, profil span 3 baris --}}
    <div class="px-4">
        <div class="grid w-full max-w-3xl mx-auto gap-6
                   grid-cols-1 lg:grid-cols-2 lg:auto-rows-max">

            {{-- Kolom kiri: Profil (span 3 baris agar setinggi kolom kanan) --}}
            <section class="lg:row-span-3">
                <div class="bg-white rounded-xl border shadow p-6 h-[680px] flex flex-col">
                    <h3 class="font-extrabold mb-4">PROFIL</h3>

                    {{-- Avatar --}}
                    <div class="w-full flex justify-center mb-6">
                        <div class="w-32 h-32 rounded-full bg-gray-100 border flex items-center justify-center">
                            <i class="fas fa-user text-5xl text-gray-300"></i>
                        </div>
                    </div>

                    {{-- Detail Profile --}}
                    <dl class="text-sm">
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">STUDENT ID</dt>
                            <dd>: {{ $user->nim ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">FULL NAME</dt>
                            <dd>: {{ $user->name_asli ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">PHONE</dt>
                            <dd>: {{ $profile->phone ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">ADDRESS</dt>
                            <dd>: {{ $profile->address ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <dt class="text-gray-500">EMAIL</dt>
                            <dd>: {{ $profile->email_pribadi ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2">
                            <dt class="text-gray-500">MOTIVATION</dt>
                            <dd>: {{ $profile->motivation ?? '-' }}</dd>
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
            <section class="space-y-6">
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
                            <span class="text-gray-500">CITY</span><span>: {{ $school->city ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <span class="text-gray-500">REGENCY</span><span>: {{ $school->regency ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[140px,auto] py-2 border-b">
                            <span class="text-gray-500">PROVINCE</span><span>: {{ $school->province ?? '-' }}</span>
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
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-5xl bg-white shadow-lg">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-2xl font-extrabold">PROFILE</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editProfileModal')">✕</button>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('mhs.profile.save') }}" class="px-6 py-6">
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



    {{-- ===== Script modal (vanilla JS) ===== --}}
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
            if (e.key === 'Escape') closeModal('editModal');
        }
    </script>

    {{-- ===== MODAL CAMPUS ACTIVITIES (kecil + center) ===== --}}
    <div id="editActivitiesModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editActivitiesModal')"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-sm rounded bg-white shadow-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-2xl font-extrabold">CAMPUS ACTIVITIES</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editActivitiesModal')">✕</button>
                </div>

                <form method="POST" action="{{ route('mhs.profile.activities') }}" class="px-6 py-6">
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

                        // Pisahkan mana yang default (untuk dicentang) dan mana yang custom
                        $checkedDefaults = array_intersect($actArr, $defaults);
                        $customActs = array_values(array_diff($actArr, $defaults));
                    @endphp

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
                    <div id="actsCustomWrap" class="mt-4 space-y-4 text-lg">
                        @foreach ($customActs as $txt)
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500 act-toggle"
                                    checked>
                                <input type="text" name="activities[]" value="{{ $txt }}" maxlength="50"
                                    class="flex-1 h-10 rounded-lg border border-gray-300 px-3 text-base act-input">
                            </div>
                        @endforeach
                    </div>

                    {{-- Others / Add --}}
                    <button type="button" class="mt-5 text-gray-500 underline underline-offset-4"
                        onclick="addActivityRow()">Others / Add</button>

                    <div class="mt-8 flex justify-center">
                        <button
                            class="w-64 h-11 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}
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
        }

        // Wire existing custom rows on load
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#actsCustomWrap > div').forEach(wireActRow);
        });
    </script>


    {{-- ===== MODAL SKILLS (kecil + center) ===== --}}
    <div id="editSkillsModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editSkillsModal')"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-sm rounded bg-white shadow-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-2xl font-extrabold">SKILLS</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editSkillsModal')">✕</button>
                </div>

                <form method="POST" action="{{ route('mhs.profile.skills') }}" class="px-6 py-6">
                    @csrf
                    @php
                        // Opsi default
                        $skillDefaults = ['Adobe Photoshop', 'Corel Draw', 'Blender', 'AutoCAD', 'Adobe Illustrator'];

                        // Data existing dari DB → pisahkan default vs custom
                        $skillArr = ($skills ?? collect())->pluck('skill')->values()->all();
                        $checkedDefaultSkills = array_intersect($skillArr, $skillDefaults);
                        $customSkills = array_values(array_diff($skillArr, $skillDefaults));
                    @endphp

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
                    <div id="skillsCustomWrap" class="mt-4 space-y-4 text-lg">
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
                    <button type="button" class="mt-5 text-gray-500 underline underline-offset-4"
                        onclick="addSkillRow()">Others / Add</button>

                    <div class="mt-8 flex justify-center">
                        <button
                            class="w-64 h-11 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}
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

                            <div>
                                <label class="block text-lg font-semibold mb-1">Regency</label>
                                <input type="text" name="regency" value="{{ old('regency', $school->regency) }}"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-lg font-semibold mb-1">Province</label>
                                <input type="text" name="province" value="{{ old('province', $school->province) }}"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Kanan --}}
                        <div class="space-y-5">
                            <div>
                                <label class="block text-lg font-semibold mb-1">City</label>
                                <input type="text" name="city" value="{{ old('city', $school->city) }}"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
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
        // modal helpers
        window.__currentModal = null;

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
