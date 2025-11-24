<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CV - {{ $user->name_asli }}</title>

    {{-- Tailwind via CDN (dipakai Chrome-nya Browsershot) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome untuk icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        /* ===== A4 fixed ===== */
        html,
        body {
            margin: 0;
            padding: 0;
        }

        .page {
            width: 794px;
            /* 21 cm @ 96dpi */
            min-height: 1123px;
            /* 29.7 cm */
            margin: 0 auto;
            background: #ffffff;
            padding: 24px 32px;
            display: flex;
            flex-direction: column;
        }

        .page-main {
            flex: 1;
            /* isi utama dorong footer ke bawah */
        }

        /* grid row: tinggi minimal mengikuti konten, tapi sisa ruang dibagi rata */
        .auto-rows-minmax {
            grid-auto-rows: minmax(min-content, 1fr);
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            body {
                background: #ffffff !important;
            }

            .page {
                margin: 0 !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="page">

        {{-- HEADER / TITLE --}}
        <header class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold tracking-wide">
                CURRICULUM VITAE
            </h1>
        </header>

        <main class="page-main">
            {{-- GRID 2 KOLOM --}}
            <div class="grid grid-cols-2 gap-6 auto-rows-minmax">

                {{-- LEFT COLUMN: PROFILE (span 3 rows) --}}
                <section class="col-span-1 row-span-3 bg-white rounded-xl border shadow p-6">
                    <h3 class="font-extrabold mb-4">PROFIL</h3>

                    {{-- Avatar --}}
                    <div class="flex justify-center mb-6">
                        <div class="w-32 h-32 rounded-full border overflow-hidden bg-gray-100">
                            @if (!empty($profile['photo'] ?? null))
                                <img src="{{ public_path('uploads/profiles/' . ($profile['photo'] ?? '')) }}"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:999px;" alt="Avatar">
                            @else
                                <div class="avatar-placeholder">
                                    <span>👤</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Detail --}}
                    <dl class="text-sm space-y-2">
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <dt class="text-gray-500">STUDENT ID</dt>
                            <dd>: {{ $user->nim }}</dd>
                        </div>
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <dt class="text-gray-500">FULL NAME</dt>
                            <dd>: {{ $user->name_asli }}</dd>
                        </div>
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <dt class="text-gray-500">PHONE</dt>
                            <dd>: {{ $profile->phone ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <dt class="text-gray-500">ADDRESS</dt>
                            <dd>: {{ $profile->address ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <dt class="text-gray-500">EMAIL</dt>
                            <dd>: {{ $profile->email_pribadi ?? '-' }}</dd>
                        </div>
                        <div class="grid grid-cols-[130px,auto]">
                            <dt class="text-gray-500">MOTIVATION</dt>
                            <dd>: {{ $profile->motivation ?? '-' }}</dd>
                        </div>
                    </dl>

                    {{-- Tags --}}
                    @php
                        $tags = is_array($profile->tags ?? null) ? $profile->tags : [];
                    @endphp
                    @if (count($tags))
                        <div class="mt-4 pt-3 border-t flex flex-wrap gap-2">
                            @foreach ($tags as $t)
                                <span class="px-5 py-1 bg-blue-600 text-white rounded text-xs font-semibold">
                                    {{ $t }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </section>

                {{-- RIGHT COLUMN: CAMPUS ACTIVITIES --}}
                <section class="col-span-1 bg-white rounded-xl border shadow p-6">
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
                </section>

                {{-- RIGHT COLUMN: SKILLS --}}
                <section class="col-span-1 bg-white rounded-xl border shadow p-6">
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
                </section>

                {{-- RIGHT COLUMN: SCHOOL --}}
                <section class="col-span-1 bg-white rounded-xl border shadow p-6">
                    <h3 class="font-extrabold mb-4">SCHOOL</h3>
                    <div class="space-y-2 text-sm">
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <span class="text-gray-500">SCHOOL ORIGIN</span>
                            <span>: {{ $school->school_origin ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <span class="text-gray-500">PROVINCE</span>
                            <span>: {{ $school->province ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <span class="text-gray-500">REGENCY</span>
                            <span>: {{ $school->regency ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[130px,auto] border-b pb-1">
                            <span class="text-gray-500">CITY</span>
                            <span>: {{ $school->city ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-[130px,auto]">
                            <span class="text-gray-500">LEVEL</span>
                            <span>: {{ $school->level ?? '-' }}</span>
                        </div>
                    </div>
                </section>

            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="mt-6 pt-3 border-t text-center text-xs text-gray-500">
            PortfolioFAD — Faculty of Art & Design, UKDW
        </footer>

    </div>

</body>

</html>
