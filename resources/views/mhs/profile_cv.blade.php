<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CV - {{ $user->name_asli }}</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ====== FIX A4 ====== */
        .page {
            width: 794px;       /* 21cm */
            min-height: 1123px; /* 29.7cm */
            margin: 0 auto;
            padding: 20px 32px;
            background: white;
        }

        body {
            background: #e5e5e5 !important;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            body, html {
                width: 794px !important;
                height: 1123px !important;
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
            }

            .page {
                margin: 0 !important;
                padding: 20px 32px !important;
                width: 794px !important;
                min-height: 1123px !important;
                box-shadow: none !important;
                transform: scale(1) !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    {{-- PRINT BUTTON --}}
    <div class="no-print w-full flex justify-center my-6">
        <button onclick="window.print()"
            class="px-6 py-2 rounded-md bg-blue-600 text-white font-semibold hover:bg-blue-700">
            PRINT CV (PDF)
        </button>
    </div>

    <div class="page">

        {{-- TITLE --}}
        <h1 class="text-center text-3xl font-extrabold mb-6 tracking-wide">
            CURRICULUM VITAE
        </h1>

        {{-- GRID UTAMA IDENTIK --}}
        <div class="grid grid-cols-2 gap-6">

            {{-- PROFIL --}}
            <div class="col-span-1 bg-white rounded-xl border shadow p-6">

                <h3 class="font-extrabold mb-4">PROFIL</h3>

                <div class="flex justify-center mb-6">
                    <div class="w-32 h-32 rounded-full border overflow-hidden bg-gray-100">
                        @if(!empty($profile->photo_url))
                            <img src="{{ $profile->photo_url }}" class="w-full h-full object-cover" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-user text-5xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <dl class="text-sm space-y-2">
                    <div class="grid grid-cols-[130px,auto] border-b pb-1">
                        <dt class="text-gray-500">STUDENT ID</dt>
                        <dd class="">: {{ $user->nim }}</dd>
                    </div>

                    <div class="grid grid-cols-[130px,auto] border-b pb-1">
                        <dt class="text-gray-500">FULL NAME</dt>
                        <dd class="">: {{ $user->name_asli }}</dd>
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

                {{-- TAGS --}}
                @php $tags = is_array($profile->tags ?? null) ? $profile->tags : []; @endphp
                @if (count($tags))
                    <div class="mt-4 pt-3 border-t flex flex-wrap gap-2">
                        @foreach ($tags as $t)
                            <span class="px-5 py-1 bg-blue-600 text-white rounded text-xs font-semibold">
                                {{ $t }}
                            </span>
                        @endforeach
                    </div>
                @endif

            </div>

            {{-- KANAN KOLOM ATAS --}}
            <div class="col-span-1 bg-white rounded-xl border shadow p-6">
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
            </div>

            {{-- SKILLS --}}
            <div class="col-span-1 bg-white rounded-xl border shadow p-6">
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
            </div>

            {{-- SCHOOL --}}
            <div class="col-span-1 bg-white rounded-xl border shadow p-6">
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
            </div>

        </div>

    </div>

</body>

</html>
