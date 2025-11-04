<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&amp;family=Roboto&amp;display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3ede4;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="relative min-h-screen overflow-x-hidden bg-[url('/BG.png')] bg-no-repeat bg-left-top bg-cover">
    <div class="px-6 sm:px-8 pt-6">
        <div class="flex items-center justify-between">
            <img src="/DWDP.png" alt="Logo" class="h-16 w-auto object-contain">
            <div class="flex items-center gap-2">
                <a href="/aboutUS" class="italic text-black hover:text-gray-800 hover:underline transition">About us</a>
            </div>
        </div>
    </div>

    {{-- ===== Helpers & Slots (7 slot) ===== --}}
    @php
        use Illuminate\Support\Str;

        // Susunan slot berdasarkan baris (top->bottom)
        // Baris 1: LeftTop, RightTop
        // Baris 2: LeftMid, RightMid
        // Baris 3: LeftBot, CenterWide, RightBot
        $slotKeys = ['leftTop', 'rightTop', 'leftMid', 'rightMid', 'leftBot', 'centerWide', 'rightBot'];

        // Isi slot dari $projects sesuai urutan di atas
        $slots = array_fill_keys($slotKeys, null);
        if (isset($projects) && $projects instanceof \Illuminate\Support\Collection && $projects->count()) {
            foreach ($slotKeys as $i => $key) {
                if (!isset($projects[$i])) {
                    break;
                }
                $slots[$key] = $projects[$i];
            }
        }

        // ALT: ambil judul yang masuk akal
        $titleOf = function ($proj) {
            foreach (['title', 'judul', 'name', 'nama', 'project_title'] as $t) {
                if (isset($proj->$t) && $proj->$t) {
                    return trim((string) $proj->$t);
                }
            }
            return 'Project';
        };

        // URL Cover: samakan dengan Gallery → pakai display_cover_url jika ada; fallback ke /images/placeholder.png
        $coverOf = function ($proj, $isWide = false) use ($titleOf) {
            if ($proj) {
                $cover = $proj->display_cover_url ?? null;
                if ($cover) {
                    // jika sudah absolute or root path, langsung pakai
                    if (Str::startsWith($cover, ['http://', 'https://', '/', 'data:'])) {
                        return $cover;
                    }
                    // kalau relatif, jadikan asset (public)
                    return asset($cover);
                }
                // fallback: placeholder.png (siapkan di public/images/placeholder.png)
                return asset('images/placeholder.png');
            }
            // Jika slot kosong → SVG "NO PROJECT"
            if ($isWide) {
                return 'data:image/svg+xml;utf8,' .
                    rawurlencode("
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 600'>
                        <rect width='100%' height='100%' fill='#f3f4f6'/>
                        <text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle'
                              font-family='Poppins, Arial, sans-serif' font-size='72' fill='#9ca3af'>
                            NO PROJECT
                        </text>
                    </svg>
                ");
            }
            return 'data:image/svg+xml;utf8,' .
                rawurlencode("
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'>
                    <rect width='100%' height='100%' fill='#f3f4f6'/>
                    <text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle'
                          font-family='Poppins, Arial, sans-serif' font-size='64' fill='#9ca3af'>
                        NO PROJECT
                    </text>
                </svg>
            ");
        };

        // ALT text untuk img
        $altFor = function ($proj) use ($titleOf) {
            return $proj ? e($titleOf($proj)) : 'No Project';
        };
    @endphp

    <main class="max-w-7xl mx-auto py-12 grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-12">
        {{-- ========= Left Column (3 kotak: Top, Mid, Bot) ========= --}}
        <div class="flex flex-col gap-y-12">
            {{-- LeftTop --}}
            <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img alt="{{ $altFor($slots['leftTop']) }}" class="w-full aspect-square object-cover" height="220"
                    src="{{ $coverOf($slots['leftTop'], false) }}" width="320" />
                <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                    @php
                        $slot = $slots['leftTop']; // ubah sesuai slot
                        $interaction = $slot?->currentViewerInteraction;
                        $liked = (bool) ($interaction->liked ?? false);
                        $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                        $hasComment = count($commentsArr) > 0;
                    @endphp
                    {{-- Tombol Like --}}
                    <button type="button" class="like-btn hover:scale-110 transition"
                        data-like-url="{{ $slot ? route('projects.like', $slot) : '#' }}"
                        aria-pressed="{{ $liked ? 'true' : 'false' }}" title="{{ $liked ? 'Unlike' : 'Like' }}">
                        <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                    </button>

                    {{-- Tombol Comment --}}
                    <button type="button" class="comment-btn hover:scale-110 transition"
                        data-project-id="{{ $slot?->id }}" data-existing='@json($commentsArr)'
                        data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                        <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    </button>
                </figcaption>
            </figure>

            {{-- LeftMid --}}
            <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img alt="{{ $altFor($slots['leftMid']) }}" class="w-full aspect-square object-cover" height="220"
                    src="{{ $coverOf($slots['leftMid'], false) }}" width="320" />
                <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                    @php
                        $slot = $slots['leftMid']; // ubah sesuai slot
                        $interaction = $slot?->currentViewerInteraction;
                        $liked = (bool) ($interaction->liked ?? false);
                        $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                        $hasComment = count($commentsArr) > 0;
                    @endphp
                    {{-- Tombol Like --}}
                    <button type="button" class="like-btn hover:scale-110 transition"
                        data-like-url="{{ $slot ? route('projects.like', $slot) : '#' }}"
                        aria-pressed="{{ $liked ? 'true' : 'false' }}" title="{{ $liked ? 'Unlike' : 'Like' }}">
                        <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                    </button>

                    {{-- Tombol Comment --}}
                    <button type="button" class="comment-btn hover:scale-110 transition"
                        data-project-id="{{ $slot?->id }}" data-existing='@json($commentsArr)'
                        data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                        <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    </button>
                </figcaption>
            </figure>

            {{-- LeftBot --}}
            <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img alt="{{ $altFor($slots['leftBot']) }}" class="w-full aspect-square object-cover" height="220"
                    src="{{ $coverOf($slots['leftBot'], false) }}" width="320" />
                <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                    @php
                        $slot = $slots['leftBot']; // ubah sesuai slot
                        $interaction = $slot?->currentViewerInteraction;
                        $liked = (bool) ($interaction->liked ?? false);
                        $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                        $hasComment = count($commentsArr) > 0;
                    @endphp
                    {{-- Tombol Like --}}
                    <button type="button" class="like-btn hover:scale-110 transition"
                        data-like-url="{{ $slot ? route('projects.like', $slot) : '#' }}"
                        aria-pressed="{{ $liked ? 'true' : 'false' }}" title="{{ $liked ? 'Unlike' : 'Like' }}">
                        <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                    </button>

                    {{-- Tombol Comment --}}
                    <button type="button" class="comment-btn hover:scale-110 transition"
                        data-project-id="{{ $slot?->id }}" data-existing='@json($commentsArr)'
                        data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                        <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    </button>
                </figcaption>
            </figure>
        </div>

        {{-- ========= Center Column (Form + 1 gambar Wide di bawah) ========= --}}
        <div class="flex flex-col items-center">
            <section class="bg-[#d3ecfc] rounded-xl px-12 pt-10 pb-8 w-full shadow-md">
                <h1 class="text-4xl font-extrabold text-center mb-6 leading-tight">
                    WELCOME <br /> BACK!
                </h1>

                {{-- alert error --}}
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="w-full space-y-5">
                    @csrf

                    {{-- Mahasiswa: NIM | Dosen: NIK | Admin: Username --}}
                    <div>
                        <input name="login" value="{{ old('login') }}"
                            class="w-full rounded-lg py-3 px-4 text-sm placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-400"
                            placeholder="NIM / NIK " type="text" required />
                    </div>

                    <div>
                        <input name="password"
                            class="w-full rounded-lg py-3 px-4 text-sm placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-400"
                            placeholder="Password" type="password" required />
                        <p class="text-xs italic text-right mt-1 text-slate-600">
                            {{-- taruh link reset password kalau nanti dipakai --}}
                        </p>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="#"
                            class="italic text-sm text-gray-600 hover:text-gray-800 transition-opacity duration-200 opacity-70 hover:opacity-100">
                            Forgot password?
                        </a>
                    </div>

                    <button
                        class="w-full bg-sky-400 hover:bg-sky-500 text-white font-bold py-3 rounded-lg shadow-md transition-colors"
                        type="submit">
                        Login
                    </button>
                </form>
            </section>

            {{-- CenterWide (gambar lebar di bawah form) --}}
            <div class="col-span-1 sm:col-span-2 flex flex-col items-center mt-6">
                <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                    style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="{{ $altFor($slots['centerWide']) }}" class="w-full h-[300px] object-cover"
                        height="220" src="{{ $coverOf($slots['centerWide'], true) }}" width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        @php
                            $slot = $slots['centerWide']; // ubah sesuai slot
                            $interaction = $slot?->currentViewerInteraction;
                            $liked = (bool) ($interaction->liked ?? false);
                            $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                            $hasComment = count($commentsArr) > 0;
                        @endphp
                        {{-- Tombol Like --}}
                        <button type="button" class="like-btn hover:scale-110 transition"
                            data-like-url="{{ $slot ? route('projects.like', $slot) : '#' }}"
                            aria-pressed="{{ $liked ? 'true' : 'false' }}" title="{{ $liked ? 'Unlike' : 'Like' }}">
                            <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                        </button>

                        {{-- Tombol Comment --}}
                        <button type="button" class="comment-btn hover:scale-110 transition"
                            data-project-id="{{ $slot?->id }}" data-existing='@json($commentsArr)'
                            data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                            <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                        </button>
                    </figcaption>
                </figure>
                <a href="{{ route('gallery') }}"
                    class="mt-6 text-sm font-semibold italic text-slate-700 hover:text-slate-900">
                    SHOW MORE &raquo;&raquo;
                </a>
            </div>
        </div>

        {{-- ========= Right Column (3 kotak: Top, Mid, Bot) ========= --}}
        <div class="flex flex-col gap-y-12">
            {{-- RightTop --}}
            <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img alt="{{ $altFor($slots['rightTop']) }}" class="w-full aspect-square object-cover"
                    height="220" src="{{ $coverOf($slots['rightTop'], false) }}" width="320" />
                <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                    @php
                        $slot = $slots['rightTop']; // ubah sesuai slot
                        $interaction = $slot?->currentViewerInteraction;
                        $liked = (bool) ($interaction->liked ?? false);
                        $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                        $hasComment = count($commentsArr) > 0;
                    @endphp
                    {{-- Tombol Like --}}
                    <button type="button" class="like-btn hover:scale-110 transition"
                        data-like-url="{{ $slot ? route('projects.like', $slot) : '#' }}"
                        aria-pressed="{{ $liked ? 'true' : 'false' }}" title="{{ $liked ? 'Unlike' : 'Like' }}">
                        <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                    </button>

                    {{-- Tombol Comment --}}
                    <button type="button" class="comment-btn hover:scale-110 transition"
                        data-project-id="{{ $slot?->id }}" data-existing='@json($commentsArr)'
                        data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                        <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    </button>
                </figcaption>
            </figure>

            {{-- RightMid --}}
            <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img alt="{{ $altFor($slots['rightMid']) }}" class="w-full aspect-square object-cover"
                    height="220" src="{{ $coverOf($slots['rightMid'], false) }}" width="320" />
                <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                    @php
                        $slot = $slots['rightMid']; // ubah sesuai slot
                        $interaction = $slot?->currentViewerInteraction;
                        $liked = (bool) ($interaction->liked ?? false);
                        $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                        $hasComment = count($commentsArr) > 0;
                    @endphp
                    {{-- Tombol Like --}}
                    <button type="button" class="like-btn hover:scale-110 transition"
                        data-like-url="{{ $slot ? route('projects.like', $slot) : '#' }}"
                        aria-pressed="{{ $liked ? 'true' : 'false' }}" title="{{ $liked ? 'Unlike' : 'Like' }}">
                        <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                    </button>

                    {{-- Tombol Comment --}}
                    <button type="button" class="comment-btn hover:scale-110 transition"
                        data-project-id="{{ $slot?->id }}" data-existing='@json($commentsArr)'
                        data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                        <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    </button>
                </figcaption>
            </figure>

            {{-- RightBot --}}
            <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                style="box-shadow: 2px 2px 6px #b8b8b8;">
                <img alt="{{ $altFor($slots['rightBot']) }}" class="w-full aspect-square object-cover"
                    height="220" src="{{ $coverOf($slots['rightBot'], false) }}" width="320" />
                <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                    @php
                        $slot = $slots['rightBot']; // ubah sesuai slot
                        $interaction = $slot?->currentViewerInteraction;
                        $liked = (bool) ($interaction->liked ?? false);
                        $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                        $hasComment = count($commentsArr) > 0;
                    @endphp
                    {{-- Tombol Like --}}
                    <button type="button" class="like-btn hover:scale-110 transition"
                        data-like-url="{{ $slot ? route('projects.like', $slot) : '#' }}"
                        aria-pressed="{{ $liked ? 'true' : 'false' }}" title="{{ $liked ? 'Unlike' : 'Like' }}">
                        <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                    </button>

                    {{-- Tombol Comment --}}
                    <button type="button" class="comment-btn hover:scale-110 transition"
                        data-project-id="{{ $slot?->id }}" data-existing='@json($commentsArr)'
                        data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                        <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    </button>
                </figcaption>
            </figure>
        </div>
    </main>
    <!-- Comment Modal -->
    <div id="commentModal" class="fixed inset-0 bg-black/40 z-50 hidden justify-center items-center">
        <div class="bg-white rounded-xl p-6 w-80 shadow-lg relative">
            <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                🎨 Choose Comment Type
            </h2>

            <form id="commentForm" class="space-y-2">
                @php
                    $commentOptions = [
                        'The design is unique',
                        'Needs improvement in shape',
                        'Interesting color/composition',
                        'Good functionality',
                        'Very creative idea',
                        'Visually balanced and pleasing',
                        'The concept feels fresh and original',
                        'Could use better material selection',
                        'Excellent craftsmanship',
                        'Innovative use of form and texture',
                        'Strong visual identity',
                    ];
                @endphp
                @foreach ($commentOptions as $opt)
                    <label class="flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="comments[]" value="{{ $opt }}"
                            class="text-blue-600 rounded">
                        <span>{{ $opt }}</span>
                    </label>
                @endforeach

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" onclick="closeCommentModal()"
                        class="px-3 py-1 text-sm bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                    <button type="submit"
                        class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ========== LIKE ==========
            function toggleLike(url, btn, icon) {
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({}),
                        credentials: 'same-origin',
                    })
                    .then(r => {
                        if (!r.ok) throw new Error('Like failed: ' + r.status);
                        return r.json();
                    })
                    .then(data => {
                        const liked = !!data.liked;
                        btn.setAttribute('aria-pressed', liked ? 'true' : 'false');
                        btn.setAttribute('title', liked ? 'Unlike' : 'Like');
                        icon.classList.toggle('text-red-600', liked);
                        icon.classList.toggle('text-gray-400', !liked);
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal memproses like. Coba lagi.');
                    });
            }

            document.querySelectorAll('.like-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.likeUrl;
                    const icon = this.querySelector('.fa-heart');
                    toggleLike(url, this, icon);
                });
            });

            // ========== COMMENT MODAL ==========
            const modal = document.getElementById('commentModal');
            const form = document.getElementById('commentForm');
            let activeProjectId = null;
            let activeCommentBtn = null;

            // helpers
            function openCommentModal(projectId, existingComments) {
                activeProjectId = projectId;
                // reset & prefill
                form.reset();
                if (Array.isArray(existingComments)) {
                    const set = new Set(existingComments);
                    form.querySelectorAll('input[name="comments[]"]').forEach(cb => {
                        cb.checked = set.has(cb.value);
                    });
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            window.closeCommentModal = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                form.reset();
                activeProjectId = null;
                activeCommentBtn = null;
            };

            // open modal on click
            document.querySelectorAll('.comment-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    activeCommentBtn = this;
                    const pid = this.dataset.projectId;
                    let existing = [];
                    try {
                        existing = JSON.parse(this.dataset.existing || '[]');
                    } catch (_) {}
                    openCommentModal(pid, existing);
                });
            });

            // submit comments
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!activeProjectId) return;

                const selected = [...form.querySelectorAll('input[name="comments[]"]:checked')].map(cb => cb
                    .value);

                // Kalau kosong, konfirmasi penghapusan (opsional)
                if (selected.length === 0) {
                    const ok = confirm('Delete all comments?');
                    if (!ok) return;
                }

                fetch(`/projects/${activeProjectId}/comments`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            comments: selected
                        }),
                        credentials: 'same-origin',
                    })
                    .then(r => {
                        if (!r.ok) throw new Error('Comment failed: ' + r.status);
                        return r.json();
                    })
                    .then(data => {
                        // Update ikon sesuai hasil
                        if (activeCommentBtn) {
                            const icon = activeCommentBtn.querySelector('.fa-comment');
                            if (data.has_comments) {
                                icon.classList.remove('text-gray-400');
                                icon.classList.add('text-blue-600');
                                activeCommentBtn.dataset.commented = '1';
                                activeCommentBtn.dataset.existing = JSON.stringify(selected);
                            } else {
                                icon.classList.remove('text-blue-600');
                                icon.classList.add('text-gray-400');
                                activeCommentBtn.dataset.commented = '0';
                                activeCommentBtn.dataset.existing = '[]';
                            }
                        }
                        closeCommentModal();
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to save comments.');
                    });
            });

        });
    </script>


</body>

</html>
