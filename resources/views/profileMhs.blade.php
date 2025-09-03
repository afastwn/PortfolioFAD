@extends('layouts.app')

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
                <div class="bg-white rounded-xl border shadow p-6 h-[805px] flex flex-col">
                    <h3 class="font-extrabold mb-4">PROFIL</h3>

                    {{-- Avatar --}}
                    <div class="w-full flex justify-center mb-6">
                        <div class="w-32 h-32 rounded-full bg-gray-100 border flex items-center justify-center">
                            <i class="fas fa-user text-5xl text-gray-300"></i>
                        </div>
                    </div>

                    {{-- Detail --}}
                    <dl class="text-sm">
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <dt class="text-gray-500">STUDENT ID</dt>
                            <dd>: 72220525</dd>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <dt class="text-gray-500">FULL NAME</dt>
                            <dd>: Filistera Santoso</dd>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <dt class="text-gray-500">PHONE</dt>
                            <dd>: 77777777</dd>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <dt class="text-gray-500">ADDRESS</dt>
                            <dd>: Pati</dd>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <dt class="text-gray-500">EMAIL</dt>
                            <dd>: @l23</dd>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2">
                            <dt class="text-gray-500">MOTIVATION</dt>
                            <dd>: i want...</dd>
                        </div>
                    </dl>

                    {{-- Tags --}}
                    <div class="mt-4 pt-4 border-t flex gap-2 flex-wrap justify-center">
                        <span class="px-7 py-1 text-sm font-semibold bg-blue-700 text-white">Good</span>
                        <span class="px-7 py-1 text-sm font-semibold bg-blue-700 text-white">Smart</span>
                        <span class="px-7 py-1 text-sm font-semibold bg-blue-700 text-white">Fast</span>
                    </div>


                    {{-- Tombol edit (tetap di bawah tag biru, bukan absolute) --}}
                    <div class="mt-4 flex justify-end">
                        <button class="text-blue-600 hover:text-blue-800 transition" title="Edit profil"
                            onclick="openModal('editModal')">
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
                    <ul class="space-y-1 text-sm">
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> TEACHING
                            ASSISTANT</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> LABORATORY
                            VOLUNTEER</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> CAMPUS UNIT
                            VOLUNTEER</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> CAMPUS EVENT
                            COMMITTEE</li>
                    </ul>
                    <div class="mt-4 flex justify-end">
                        <button class="text-blue-600 hover:text-blue-800 transition" title="Edit activities"
                            onclick="openModal('editActivitiesModal')">
                            <i class="fas fa-pen"></i>
                        </button>
                    </div>
                </div>

                {{-- SKILLS --}}
                <div class="bg-white rounded-xl border shadow p-6">
                    <h3 class="font-extrabold mb-4">SKILLS</h3>
                    <ul class="space-y-1 text-sm">
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> ADOBE
                            PHOTOSHOP</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> COREL DRAW
                        </li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> BLENDER</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> ILLUSTRATOR
                        </li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-square text-blue-600"></i> AUTOCAD</li>
                    </ul>
                    <div class="mt-4 flex justify-end">
                        <button class="text-blue-600 hover:text-blue-800" title="Edit skills"
                            onclick="openModal('editSkillsModal')"><i class="fas fa-pen"></i></button>
                    </div>
                </div>

                {{-- SCHOOL --}}
                <div class="bg-white rounded-xl border shadow p-6">
                    <h3 class="font-extrabold mb-4">SCHOOL</h3>
                    <div class="text-sm space-y-1">
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <span class="text-gray-500">SCHOOL ORIGIN</span><span>: Pati</span>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <span class="text-gray-500">ADDRESS</span><span>: Pati</span>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2 border-b">
                            <span class="text-gray-500">CITY/REGENCY</span><span>: Pati</span>
                        </div>
                        <div class="grid grid-cols-[120px,auto] py-2">
                            <span class="text-gray-500">MAJOR</span><span>: Sains</span>
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
    <div id="editModal" class="fixed inset-0 z-[100] hidden">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editModal')"></div>

        {{-- Wrapper flex untuk center --}}
        <div class="absolute inset-0 flex items-center justify-center p-4">
            {{-- Dialog --}}
            <div class="w-full max-w-3xl  bg-white shadow-lg">
                {{-- Header --}}
                <div class="flex items-center justify-between px-5 py-3 border-b">
                    <h3 class="text-lg font-extrabold tracking-wide">PROFILE</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editModal')"
                        aria-label="Close">✕</button>
                </div>

                {{-- Body: form --}}
                <form method="GET" action="/profileMhs" class="px-5 py-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kolom kiri --}}
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Student ID</label>
                                <input type="text" class="w-full h-9 rounded-md border border-gray-300 px-2"
                                    value="72220525">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Full Name</label>
                                <input type="text" class="w-full h-9 rounded-md border border-gray-300 px-2"
                                    value="Filistera Santoso">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Phone Number</label>
                                <input type="text" class="w-full h-9 rounded-md border border-gray-300 px-2"
                                    value="77777777">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Address</label>
                                <input type="text" class="w-full h-9 rounded-md border border-gray-300 px-2"
                                    value="Pati">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Personal Email</label>
                                <input type="email" class="w-full h-9 rounded-md border border-gray-300 px-2"
                                    value="@l23">
                            </div>
                        </div>

                        {{-- Kolom kanan --}}
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-base font-bold">Motivation and Problem-Solving</h4>
                                <p class="text-xs text-gray-500">Describe your motivation and how you solve problems</p>
                                <textarea class="mt-2 w-full h-24 rounded-md border border-gray-300 px-2 resize-none"></textarea>
                            </div>

                            <div>
                                <h4 class="text-base font-bold mb-2">Describe Yourself in 3 Words</h4>
                                <button type="button"
                                    class="px-4 py-1.5 text-sm font-semibold text-blue-600 bg-cyan-100 rounded-md">
                                    + Add
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-6 flex justify-center">
                        <button type="submit"
                            class="w-48 h-10 rounded-md bg-blue-600 text-white font-bold hover:bg-blue-700">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}



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
            <div class="w-full max-w-sm rounded-xl bg-white shadow-lg">
                <div class="flex items-center justify-between px-4 py-3 border-b">
                    <h3 class="text-lg font-extrabold">CAMPUS ACTIVITIES</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editActivitiesModal')"
                        aria-label="Close">✕</button>
                </div>

                <form method="GET" action="/profileMhs" class="px-5 py-4 space-y-4">
                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="activities[]" value="Teaching Assistant"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                        <span>Teaching Assistant</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="activities[]" value="Laboratory Volunteer"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                        <span>Laboratory Volunteer</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="activities[]" value="Campus Unit Volunteer"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Campus Unit Volunteer</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="activities[]" value="Campus Event Committee"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Campus Event Committee</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="activities[]" value="Student Organization Member"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Student Organization Member</span>
                    </label>

                    {{-- Others (awal kosong). data-name dipakai JS untuk name field --}}
                    <div id="othersListAct" class="space-y-2" data-name="activities[]"></div>

                    {{-- Add more (tambah 1 baris checkbox+input tiap dicentang) --}}
                    <label class="flex items-center gap-3 text-base">
                        <input id="otherAdderAct" type="checkbox"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            onclick="addOtherField('othersListAct','otherAdderAct')">
                        <span class="underline underline-offset-4 text-gray-500">Others / Add</span>
                    </label>

                    <div class="pt-2 flex justify-center">
                        <button type="submit"
                            class="w-56 h-10 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}


    {{-- ===== MODAL SKILLS (kecil + center) ===== --}}
    <div id="editSkillsModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editSkillsModal')"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-sm rounded-xl bg-white shadow-lg">
                <div class="flex items-center justify-between px-4 py-3 border-b">
                    <h3 class="text-lg font-extrabold">SKILLS</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editSkillsModal')"
                        aria-label="Close">✕</button>
                </div>

                <form method="GET" action="/profileMhs" class="px-5 py-4 space-y-4">
                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="skills[]" value="Adobe Photoshop"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                        <span>Adobe Photoshop</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="skills[]" value="Corel Draw"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Corel Draw</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="skills[]" value="Blender"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Blender</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="skills[]" value="AdobeCAD"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>AdobeCAD</span>
                    </label>

                    <label class="flex items-center gap-3 text-base">
                        <input type="checkbox" name="skills[]" value="Adobe Illustrator"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Adobe Illustrator</span>
                    </label>

                    {{-- Others untuk skills --}}
                    <div id="othersListSkills" class="space-y-2" data-name="skills[]"></div>

                    <label class="flex items-center gap-3 text-base">
                        <input id="otherAdderSkills" type="checkbox"
                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            onclick="addOtherField('othersListSkills','otherAdderSkills')">
                        <span class="underline underline-offset-4 text-gray-500">Others / Add</span>
                    </label>

                    <div class="pt-2 flex justify-center">
                        <button type="submit"
                            class="w-56 h-10 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                            SUBMIT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===== /MODAL ===== --}}

    {{-- ===== MODAL SCHOOL (persegi panjang + center) ===== --}}
    <div id="editSchoolModal" class="fixed inset-0 z-[100] hidden">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50" onclick="closeModal('editSchoolModal')"></div>

        {{-- Center wrapper --}}
        <div class="absolute inset-0 flex items-center justify-center p-4">
            {{-- Dialog: persegi panjang --}}
            <div class="w-full max-w-3xl bg-white shadow-lg">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-2xl font-extrabold">SCHOOL</h3>
                    <button class="p-1.5 rounded hover:bg-gray-100" onclick="closeModal('editSchoolModal')"
                        aria-label="Close">✕</button>
                </div>

                {{-- Body --}}
                <form method="GET" action="/profileMhs" class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kolom kiri --}}
                        <div class="space-y-5">
                            <div>
                                <label class="block text-lg font-semibold mb-1">School Origin</label>
                                <input type="text" name="school_origin"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-lg font-semibold mb-1">Regency</label>
                                <input type="text" name="regency"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-lg font-semibold mb-1">Province</label>
                                <input type="text" name="province"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Kolom kanan --}}
                        <div class="space-y-5">
                            <div>
                                <label class="block text-lg font-semibold mb-1">City/Regency</label>
                                <input type="text" name="city"
                                    class="w-full h-10 rounded-lg border border-gray-300 px-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            {{-- Level (pilih salah satu) --}}
                            <div class="pt-1">

                                <label class="flex items-center gap-3 text-base mb-2">
                                    <input type="radio" name="school_level" value="SMA"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500" checked>
                                    <span>SMA</span>
                                </label>

                                <label class="flex items-center gap-3 text-base">
                                    <input type="radio" name="school_level" value="SMK"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500">
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
