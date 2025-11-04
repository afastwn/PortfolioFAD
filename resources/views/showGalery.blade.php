<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Galery</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[url('/BG.png')] bg-no-repeat bg-left-top bg-cover">

    <!-- WRAPPER: kotak putih besar -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 py-8">
        <div class="rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
            <!-- HEADER TOP: Logo (kiri) & HELLO (kanan) -->
            <div class="px-6 sm:px-8 pt-6">
                <div class="flex items-center justify-between">
                    <a href="/login"><img src="/DWDP.png" alt="Logo" class="h-16 w-auto object-contain"></a>
                    <div class="flex items-center gap-2">
                        <span class="text-4xl sm:text-5xl font-extrabold tracking-tight">HELLO!</span>
                        <span class="text-5xl sm:text-6xl">👋</span>
                    </div>
                </div>
                <!-- Garis agak transparan -->
                <div class="mt-4 border-t border-gray-300/60"></div>
            </div>

            <!-- BARIS JUDUL + SHOW ENTRIES -->
            <div class="px-6 sm:px-8 py-5">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl sm:text-2xl font-extrabold">Galery</h1>
                    <label class="flex items-center gap-2 text-sm">
                        Show
                        <select class="border rounded px-2 py-1">
                            <option>10</option>
                            <option>20</option>
                            <option>30</option>
                        </select>
                        entries
                    </label>
                </div>
            </div>

            <!-- GRID GALERY -->
            <div class="px-6 sm:px-8 pb-8">
                @php
                    // file gambar dari /public
                    $images = ['G1.png', 'G2.png', 'G3.png'];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($projects as $project)
                        @php
                            $cover = $project->display_cover_url ?? asset('images/placeholder.png');
                            $interaction = $project->currentViewerInteraction;
                            $liked = (bool) ($interaction->liked ?? false);
                            $commentsArr = is_array($interaction->comments ?? null) ? $interaction->comments : [];
                            $hasComment = count($commentsArr) > 0;
                        @endphp
                        <figure class="bg-white p-4 shadow-sm" style="box-shadow: 2px 2px 6px #b8b8b8;">
                            <img src="{{ $cover }}" alt="{{ $project->title }}"
                                class="w-full aspect-square object-cover" loading="lazy">
                            <figcaption class="flex justify-center items-center space-x-6 mt-3 text-lg">
                                {{-- Like --}}
                                <button type="button" class="like-btn hover:scale-110 transition"
                                    data-like-url="{{ route('projects.like', $project) }}"
                                    aria-pressed="{{ $liked ? 'true' : 'false' }}"
                                    title="{{ $liked ? 'Unlike' : 'Like' }}">
                                    <i class="fas fa-heart {{ $liked ? 'text-red-600' : 'text-gray-400' }}"></i>
                                </button>

                                {{-- Comment --}}
                                <button type="button" class="comment-btn hover:scale-110 transition"
                                    data-project-id="{{ $project->id }}" data-existing='@json($commentsArr)'
                                    data-commented="{{ $hasComment ? '1' : '0' }}" title="Add comment">
                                    <i class="fas fa-comment {{ $hasComment ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                </button>
                            </figcaption>
                        </figure>

                    @empty
                        <p class="col-span-full text-center text-gray-500">No Project.</p>
                    @endforelse
                </div>
            </div>
            <!-- /GRID -->
        </div>
    </div>
    <!-- SIGN IN button (sementara) -->
    {{-- <div class="max-w-6xl mx-auto px-4 sm:px-6 pb-6">
        <div class="flex justify-center">
            <a href="/login"
                class="inline-flex items-center justify-center w-40 h-11 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                SIGN IN
            </a>
        </div>
    </div> --}}

    <!-- /WRAPPER -->
    <footer class="mt-10 py-8 text-center text-xs text-gray-500">
        © {{ date('Y') }} FADUKDW
    </footer>

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
