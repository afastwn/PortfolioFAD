@extends('layouts.appDosen')

@php
    /** @var \App\Models\Project $project */
    $isEdit = true;
    $readOnly = true;
@endphp

@section('title', 'View Project')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">View Project</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    {{-- tidak perlu action/update --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- LEFT: Upload Section -->
        <div class="bg-white border rounded-xl shadow p-6 space-y-8">
            <h2 class="text-2xl font-extrabold">Upload Section</h2>

            {{-- ========== Final Product Photos ========== --}}
            <div>
                <p class="font-semibold mb-2">Final Product Photo</p>
                <div class="bg-white border rounded-xl shadow p-4 flex flex-wrap gap-3">
                    @foreach ($project->final_product_urls ?? [] as $url)
                        <img src="{{ $url }}"
                            class="h-32 rounded-lg border object-contain cursor-pointer zoomable-img">
                    @endforeach
                </div>
            </div>

            {{-- ========== Design Process ========== --}}
            <div>
                <p class="font-semibold mb-2">Design Process Photos</p>
                <div class="bg-white border rounded-xl shadow p-4 flex flex-wrap gap-3">
                    @foreach ($project->design_process_urls ?? [] as $url)
                        <img src="{{ $url }}"
                            class="h-32 rounded-lg border object-contain cursor-pointer zoomable-img">
                    @endforeach
                </div>
            </div>

            {{-- ========== Testing Photo ========== --}}
            <div>
                <p class="font-semibold mb-2">Testing Photos</p>
                <div class="bg-white border rounded-xl shadow p-4 flex flex-wrap gap-3">
                    @foreach ($project->testing_photo_urls ?? [] as $url)
                        <img src="{{ $url }}"
                            class="h-32 rounded-lg border object-contain cursor-pointer zoomable-img">
                    @endforeach
                </div>
            </div>

            {{-- ========== Display Photo ========== --}}
            <div>
                <p class="font-semibold mb-2">Display Photos</p>
                <div class="bg-white border rounded-xl shadow p-4 flex flex-wrap gap-3">
                    @foreach ($project->display_photo_urls ?? [] as $url)
                        <img src="{{ $url }}"
                            class="h-32 rounded-lg border object-contain cursor-pointer zoomable-img">
                    @endforeach
                </div>
            </div>

            {{-- ========== Poster ========== --}}
            <div>
                <p class="font-semibold mb-2">Poster</p>
                <div class="bg-white border rounded-xl shadow p-4 flex flex-wrap gap-3">
                    @foreach ($project->poster_urls ?? [] as $url)
                        <img src="{{ $url }}"
                            class="h-32 rounded-lg border object-contain cursor-pointer zoomable-img">
                    @endforeach
                </div>
            </div>

            {{-- ========== Videos ========== --}}
            <div>
                <p class="font-semibold mb-2">Videos</p>
                <div class="bg-white border rounded-xl shadow p-4 flex flex-wrap gap-3">
                    @foreach ($project->video_urls ?? [] as $url)
                        <video src="{{ $url }}" class="h-40 w-64 rounded-lg border" controls></video>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT: Basic Info -->
        <div class="flex flex-col gap-4">
            <div class="bg-white border rounded-xl shadow p-6 space-y-5">
                <h2 class="text-2xl font-extrabold">Basic Info</h2>

                <div>
                    <label class="block text-sm font-semibold mb-1">Anonim</label>
                    <input type="text" readonly class="w-full border rounded-lg p-2 bg-gray-50 cursor-not-allowed"
                        value="{{ $project->anonim_name }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Project Title</label>
                    <input type="text" readonly class="w-full border rounded-lg p-2 bg-gray-50 cursor-not-allowed"
                        value="{{ $project->title }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Category</label>
                        <input type="text" readonly class="w-full border rounded-lg p-2 bg-gray-50 cursor-not-allowed"
                            value="{{ $project->category }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Course</label>
                        <input type="text" readonly class="w-full border rounded-lg p-2 bg-gray-50 cursor-not-allowed"
                            value="{{ $project->course }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Client</label>
                        <input type="text" readonly class="w-full border rounded-lg p-2 bg-gray-50 cursor-not-allowed"
                            value="{{ $project->client }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Project Date</label>
                        <input type="text" readonly class="w-full border rounded-lg p-2 bg-gray-50 cursor-not-allowed"
                            value="{{ $project->project_date ? $project->project_date->format('Y-m-d') : '-' }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Design Brief</label>
                    <textarea readonly rows="3" class="w-full rounded-lg p-3 border bg-gray-50 cursor-not-allowed">{{ $project->design_brief }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Design Process</label>
                    <textarea readonly rows="3" class="w-full rounded-lg p-3 border bg-gray-50 cursor-not-allowed">{{ $project->design_process }}</textarea>
                </div>

                <h3 class="text-lg font-bold">Specifications</h3>
                <div class="space-y-4">
                    <div>
                        <input type="text" readonly placeholder="Material Specifications"
                            class="w-full rounded-lg p-3 border bg-gray-50 cursor-not-allowed"
                            value="{{ $project->spec_material }}">
                    </div>
                    <div>
                        <input type="text" readonly placeholder="Size Specifications"
                            class="w-full rounded-lg p-3 border bg-gray-50 cursor-not-allowed"
                            value="{{ $project->spec_size }}">
                    </div>
                </div>
            </div>

            {{-- Tombol Back --}}
            <a href="{{ url()->previous() }}"
                class="w-full py-4 border rounded-lg text-center font-semibold hover:bg-gray-50 transition">
                ← Back to Profile
            </a>
        </div>
    </div>
    <!-- =================== IMAGE VIEWER MODAL =================== -->
    <div id="imageModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
        {{-- tombol close di pojok kanan atas layar --}}
        <button id="closeModal" class="absolute top-5 right-6 text-white text-5xl font-bold hover:text-gray-300 z-[60]">
            &times;
        </button>

        <div class="relative max-w-5xl w-[90%]">
            <img id="modalImage" src="" alt="Preview"
                class="max-h-[85vh] mx-auto rounded-lg shadow-lg border-4 border-white object-contain">
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("imageModal");
            const modalImg = document.getElementById("modalImage");
            const closeBtn = document.getElementById("closeModal");

            document.querySelectorAll(".zoomable-img").forEach(img => {
                img.addEventListener("click", () => {
                    modalImg.src = img.src;
                    modal.classList.remove("hidden");
                    modal.classList.add("flex");
                });
            });

            // tutup saat klik tombol silang
            closeBtn.addEventListener("click", () => {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            });

            // tutup saat klik area gelap di luar gambar
            modal.addEventListener("click", e => {
                if (e.target === modal) {
                    modal.classList.add("hidden");
                    modal.classList.remove("flex");
                }
            });
        });
    </script>

@endsection
