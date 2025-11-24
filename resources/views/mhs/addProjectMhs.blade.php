@extends('layouts.appMhs')

@php
    /** @var \App\Models\Project|null $project */
    $isEdit = isset($isEdit) && $isEdit && isset($project);
@endphp


@section('title', $isEdit ? 'Edit Project' : 'Add Project')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">My Works</h2>
        <h1 class="text-2xl font-extrabold flex items-center gap-2">
            Hello, {{ explode(' ', Auth::user()->name_asli)[0] ?? 'User' }}! 👋
        </h1>
    </header>

    <form method="POST" action="{{ $isEdit ? route('mhs.projects.update', $project) : route('mhs.projects.store') }}"
        enctype="multipart/form-data" id="projectForm" class="space-y-6">
        @csrf
        <!-- penampung hidden input delete -->
        <div id="deleteBucket" class="hidden"></div>

        @if ($isEdit)
            @method('PUT')
        @endif
        {{-- (opsional) tampilkan error validasi --}}
        @if ($errors->any())
            <div class="p-3 rounded bg-red-50 border border-red-200 text-sm text-red-700">
                <ul class="list-disc ms-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- ================= LEFT: UPLOAD SECTION ================= -->
            <div class="bg-white border rounded-xl shadow p-6 space-y-8">
                <h2 class="text-2xl font-extrabold">Upload Section</h2>

                {{-- Final Product --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold">
                            Final Product Photo <span class="text-red-500">*</span>
                        </p>
                        <button type="button" class="p-2 rounded-md border hover:bg-gray-50"
                            onclick="document.getElementById('finalProductInput').click()" title="Upload">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <input type="file" name="final_product_photos[]" accept="image/*" multiple class="hidden"
                        id="finalProductInput" onchange="handleUpload(this, 'finalProductPreview')">
                    <div class="bg-white border rounded-xl shadow p-4">
                        <div id="finalProductPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                    </div>
                </div>

                {{-- Design Process --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold">
                            Design Process Photos <span class="text-red-500">*</span>
                        </p>
                        <button type="button" class="p-2 rounded-md border hover:bg-gray-50"
                            onclick="document.getElementById('designProcessInput').click()" title="Upload">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <input type="file" name="design_process_photos[]" accept="image/*" multiple class="hidden"
                        id="designProcessInput" onchange="handleUpload(this, 'designProcessPreview')">
                    <div class="bg-white border rounded-xl shadow p-4">
                        <div id="designProcessPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                    </div>
                </div>

                {{-- Testing Photo --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold">
                            Testing Photo <span class="text-red-500">*</span>
                        </p>
                        <button type="button" class="p-2 rounded-md border hover:bg-gray-50"
                            onclick="document.getElementById('testingInput').click()" title="Upload">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <input type="file" name="testing_photos[]" accept="image/*" multiple class="hidden" id="testingInput"
                        onchange="handleUpload(this, 'testingphotoPreview')">
                    <div class="bg-white border rounded-xl shadow p-4">
                        <div id="testingphotoPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                    </div>
                </div>

                {{-- Display Photo (max 1 file) --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold">
                            Display Photo <span class="text-red-500">*</span>
                        </p>
                        <button id="uploadBtn" type="button"
                            class="p-2 rounded-md border hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            onclick="document.getElementById('displayInput').click()" title="Upload">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>

                    {{-- ⚠️ perbaikan di sini: pakai display_photos[] --}}
                    <input type="file" name="display_photos[]" accept="image/*" class="hidden" id="displayInput"
                        onchange="handleSingleUpload(this, 'displayphotoPreview', 'uploadBtn')">

                    <div class="bg-white border rounded-xl shadow p-4">
                        <div id="displayphotoPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                    </div>
                </div>



                {{-- Poster --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold">
                            Poster <span class="text-red-500">*</span>
                        </p>
                        <button type="button" class="p-2 rounded-md border hover:bg-gray-50"
                            onclick="document.getElementById('posterInput').click()" title="Upload">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <input type="file" name="poster_images[]" accept="image/*" multiple class="hidden" id="posterInput"
                        onchange="handleUpload(this, 'posterPreview')">
                    <div class="bg-white border rounded-xl shadow p-4">
                        <div id="posterPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                    </div>
                </div>

                {{-- Video --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold">
                            Video <span class="text-red-500">*</span>
                        </p>
                        <button type="button" class="p-2 rounded-md border hover:bg-gray-50"
                            onclick="document.getElementById('videoInput').click()" title="Upload">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>
                    <input type="file" name="videos[]" accept="video/*" multiple class="hidden" id="videoInput"
                        onchange="handleVideoUpload(this, 'videoPreview')">
                    <div class="bg-white border rounded-xl shadow p-4">
                        <div id="videoPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                    </div>
                </div>
            </div>

            <!-- ================= RIGHT: BASIC INFO + BUTTONS ================= -->
            <div class="flex flex-col gap-4">
                <div class="bg-white border rounded-xl shadow p-6 space-y-5">
                    <h2 class="text-2xl font-extrabold">Basic Info</h2>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Anonim <span class="text-red-500">*</span></label>
                        <input type="text" name="anonim_name" class="w-full border rounded-lg p-2" required
                            placeholder="e.g Bumblebee, Alpha, dll."
                            value="{{ old('anonim_name', $isEdit ? $project->anonim_name ?? ($currentAnonim ?? '') : $currentAnonim ?? '') }}">
                    </div>

                    <!-- Project Title -->
                    <div>
                        <label class="block text-sm font-semibold mb-1">Project Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" class="w-full border rounded-lg p-2" required
                            value="{{ old('title', $isEdit ? $project->title ?? '' : '') }}">
                    </div>

                    <!-- Category & Course -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Category <span
                                    class="text-red-500">*</span></label>
                            @php $cat = old('category', $isEdit ? ($project->category ?? '') : ''); @endphp
                            <select name="category" class="w-full border rounded-lg p-2" required>
                                <option value=""></option>
                                @foreach ([
                                    'Home and Seating Furniture',
                                    'Bedroom Furniture and Beds',
                                    'Lamps and Luminaires',
                                    'Lighting Systems',
                                    'Household Appliances and Household Accessories',
                                    'Kitchens and Kitchen Furniture',
                                    'Kitchen Taps and Sinks',
                                    'Kitchen Appliances and Kitchen Accessories',
                                    'Cookware and Cooking Utensils',
                                    'Tableware',
                                    'Bathroom and Sanitary Equipment',
                                    'Bathroom Taps and Shower Heads',
                                    'Garden Furniture',
                                    'Garden Appliances and Garden Equipment',
                                    'Outdoor and Camping Equipment',
                                    'Sports Equipment',
                                    'Hobby and Leisure',
                                    'Bicycles and Bicycle Accessories',
                                    'Babies and Children',
                                    'Personal Care, Wellness and Beauty',
                                    'Fashion and Lifestyle Accessories',
                                    'Luggage and Bags',
                                    'Eyewear',
                                    'Watches',
                                    'Jewellery',
                                    'Interior Architecture',
                                    'Interior Design Elements',
                                    'Urban Design',
                                    'Materials and Surfaces',
                                    'Office Furniture and Office Chairs',
                                    'Office Supplies and Stationery',
                                    'Tools',
                                    'Heating and Air Conditioning Technology',
                                    'Industrial Equipment, Machinery and Automation',
                                    'Robotics',
                                    'Medical Devices and Technology',
                                    'Healthcare',
                                    'Cars and Motorcycles',
                                    'Motorhomes and Caravans',
                                    'Watercraft',
                                    'Trains and Planes',
                                    'Commercial Vehicles',
                                    'Vehicle Accessories',
                                    'TV and Home Entertainment',
                                    'Audio',
                                    'Cameras and Camera Equipment',
                                    'Drones and Action Cameras',
                                    'Mobile Phones, Tablets and Wearables',
                                    'Communication Technology',
                                    'Computer and Information Technology',
                                    'Gaming and Streaming',
                                    'Packaging',
                                ] as $opt)
                                    <option value="{{ $opt }}" {{ $cat === $opt ? 'selected' : '' }}>
                                        {{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Course <span
                                    class="text-red-500">*</span></label>
                            @php $courseVal = old('course', $isEdit ? ($project->course ?? '') : ''); @endphp
                            <select name="course" class="w-full border rounded-lg p-2" required>
                                <option value=""></option>
                                @foreach (['DS1014 - Desain Dasar 1', 'DS2054 - Desain Dasar 2', 'DS3105 - Desain Produk Eksplorasi', 'DS4155 - Desain Produk Kerajinan', 'DS5215 - Desain Produk Kewirausahaan', 'DS6275 - Desain Produk Inklusif', 'DS7315 - Praktik Desain Produk Industri', 'DS8346 - Tugas Akhir'] as $c)
                                    <option value="{{ $c }}" {{ $courseVal === $c ? 'selected' : '' }}>
                                        {{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Client & Project Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Client <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="client" class="w-full border rounded-lg p-2" required
                                value="{{ old('client', $isEdit ? $project->client ?? '' : '') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Project Date <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="project_date" class="w-full border rounded-lg p-2" required
                                value="{{ old('project_date', $isEdit && !empty($project->project_date) ? \Illuminate\Support\Carbon::parse($project->project_date)->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <!-- Design Brief -->
                    <div>
                        <label class="block text-sm font-semibold mb-1">Design Brief <span
                                class="text-red-500">*</span></label>
                        <textarea name="design_brief" rows="3" required
                            class="w-full rounded-lg p-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('design_brief', $isEdit ? $project->design_brief ?? '' : '') }}</textarea>
                    </div>

                    <!-- Design Process -->
                    <div>
                        <label class="block text-sm font-semibold mb-1">Design Process <span
                                class="text-red-500">*</span></label>
                        <textarea name="design_process" rows="3" required
                            class="w-full rounded-lg p-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('design_process', $isEdit ? $project->design_process ?? '' : '') }}</textarea>
                    </div>

                    <!-- Specifications -->
                    <h3 class="text-lg font-bold">Specifications <span class="text-red-500">*</span></h3>
                    <div class="space-y-4">
                        {{-- Material Specifications --}}
                        <div>
                            <textarea name="spec_material" rows="3" placeholder="Material Specifications" required
                                class="w-full rounded-lg p-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('spec_material', $isEdit ? $project->spec_material ?? '' : '') }}</textarea>
                        </div>
                        <div>
                            <input type="text" name="spec_size" placeholder="Size Specifications" required
                                class="w-full rounded-lg p-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('spec_size', $isEdit ? $project->spec_size ?? '' : '') }}">
                        </div>
                    </div>

                </div>

                <!-- Tombol bawah -->
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('mhs.myworks') }}" class="w-full py-4 border rounded-lg text-center block">
                        Cancel
                    </a>
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-lg text-center">
                        Save Project
                    </button>
                </div>
            </div>
        </div>
    </form>



    <!-- =============== Scripts =============== -->
    <script>
        // Toggle enable/disable tombol upload Display Photo
        function setDisplayUploadEnabled(enabled) {
            const btn = document.getElementById('uploadBtn');
            if (!btn) return;
            btn.disabled = !enabled;
            btn.classList.toggle('opacity-50', !enabled);
            btn.classList.toggle('cursor-not-allowed', !enabled);
            btn.title = enabled ? 'Upload' : 'Only one file allowed';
        }

        // Handler khusus Display Photo (max 1 file)
        function handleSingleUpload(input, previewId, btnId) {
            const preview = document.getElementById(previewId);

            // bersihkan preview lama
            preview.innerHTML = '';

            const file = input.files[0];
            if (!file) {
                setDisplayUploadEnabled(true);
                return;
            }

            const wrapper = document.createElement('div');
            wrapper.className = 'relative inline-block';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);
            img.className = 'w-32 h-32 object-cover rounded-lg border';

            // tombol hapus (X)
            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.innerHTML = '✖';
            delBtn.title = 'Remove photo';
            delBtn.className = 'absolute top-1 right-1 bg-white p-1 text-xs rounded shadow';
            delBtn.onclick = () => {
                input.value = ''; // kosongkan file input
                wrapper.remove(); // hapus preview
                setDisplayUploadEnabled(true); // aktifkan tombol upload lagi
            };

            wrapper.append(img, delBtn);
            preview.appendChild(wrapper);

            // nonaktifkan tombol upload karena sudah ada 1 file
            setDisplayUploadEnabled(false);
        }
    </script>

    <script>
        // ===== Helper penyimpanan file yang dipilih per input =====
        const DT_MAP = {}; // { inputId: DataTransfer }
        function getDT(inputId) {
            if (!DT_MAP[inputId]) DT_MAP[inputId] = new DataTransfer();
            return DT_MAP[inputId];
        }

        // ===== Util deteksi video (fallback ke ekstensi) =====
        function isVideoFile(file) {
            if (file.type && file.type.startsWith('video/')) return true;
            const ext = (file.name.split('.').pop() || '').toLowerCase();
            return ['mp4', 'mov', 'avi', 'mkv', 'webm', 'm4v', '3gp', '3gpp', 'mpeg', 'mpg', 'wmv'].includes(ext);
        }

        // ===== Preview Gambar (add + delete + replace) =====
        function addImagePreview(previewEl, file, inputId) {
            const wrapper = document.createElement("div");
            wrapper.className = "relative inline-block";
            wrapper.dataset.name = file.name;
            wrapper.dataset.size = String(file.size);
            wrapper.dataset.type = file.type;

            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);
            img.className = "max-h-32 object-contain rounded-lg border";

            // Ganti (replace) file
            const editBtn = document.createElement("button");
            editBtn.type = "button";
            editBtn.innerHTML = "✏";
            editBtn.className = "absolute top-1 left-1 bg-white p-1 text-xs rounded shadow";
            editBtn.onclick = () => {
                const picker = document.createElement("input");
                picker.type = "file";
                picker.accept = "image/*";
                picker.onchange = ev => {
                    const nf = ev.target.files?.[0];
                    if (!nf || (nf.type && !nf.type.startsWith("image/"))) return;

                    const dt = getDT(inputId);
                    const items = Array.from(dt.files);
                    const idx = items.findIndex(f => f.name === file.name && f.size === file.size && f.type === file
                        .type);
                    if (idx > -1) dt.items.remove(idx);
                    dt.items.add(nf);

                    const input = document.getElementById(inputId);
                    input.files = dt.files;

                    URL.revokeObjectURL(img.src);
                    img.src = URL.createObjectURL(nf);

                    wrapper.dataset.name = nf.name;
                    wrapper.dataset.size = String(nf.size);
                    wrapper.dataset.type = nf.type;
                };
                picker.click();
            };

            // Hapus file dari daftar kiriman
            const delBtn = document.createElement("button");
            delBtn.type = "button";
            delBtn.innerHTML = "✖";
            delBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
            delBtn.onclick = () => {
                const dt = getDT(inputId);
                const items = Array.from(dt.files);
                const idx = items.findIndex(f =>
                    f.name === wrapper.dataset.name &&
                    String(f.size) === wrapper.dataset.size &&
                    f.type === wrapper.dataset.type
                );
                if (idx > -1) dt.items.remove(idx);
                document.getElementById(inputId).files = dt.files;
                wrapper.remove();
            };

            wrapper.append(img, editBtn, delBtn);
            previewEl.appendChild(wrapper);
        }

        // ===== Handler gambar: akumulasi ke DataTransfer =====
        function handleUpload(input, previewId) {
            const preview = document.getElementById(previewId);
            const dt = getDT(input.id);

            Array.from(input.files).forEach(file => {
                if (!file.type.startsWith("image/")) return;
                dt.items.add(file);
                addImagePreview(preview, file, input.id);
            });

            input.files = dt.files; // PENTING
        }

        // ===== Preview Video (add + delete + replace) =====
        function addVideoPreview(previewEl, file, inputId) {
            const wrapper = document.createElement("div");
            wrapper.className = "relative inline-block";
            wrapper.dataset.name = file.name;
            wrapper.dataset.size = String(file.size);
            wrapper.dataset.type = file.type;

            const video = document.createElement("video");
            video.src = URL.createObjectURL(file);
            video.controls = true;
            video.className = "h-40 w-64 object-contain rounded-lg border"; // lebih jelas
            video.onloadeddata = () => URL.revokeObjectURL(video.src);

            const editBtn = document.createElement("button");
            editBtn.type = "button";
            editBtn.innerHTML = "✏";
            editBtn.className = "absolute top-1 left-1 bg-white p-1 text-xs rounded shadow";
            editBtn.onclick = () => {
                const picker = document.createElement("input");
                picker.type = "file";
                picker.accept = "video/*";
                picker.onchange = ev => {
                    const nf = ev.target.files?.[0];
                    if (!nf || !isVideoFile(nf)) return;

                    const dt = getDT(inputId);
                    const items = Array.from(dt.files);
                    const idx = items.findIndex(f => f.name === file.name && f.size === file.size && f.type === file
                        .type);
                    if (idx > -1) dt.items.remove(idx);
                    dt.items.add(nf);

                    document.getElementById(inputId).files = dt.files;

                    URL.revokeObjectURL(video.src);
                    video.src = URL.createObjectURL(nf);

                    wrapper.dataset.name = nf.name;
                    wrapper.dataset.size = String(nf.size);
                    wrapper.dataset.type = nf.type;
                };
                picker.click();
            };

            const delBtn = document.createElement("button");
            delBtn.type = "button";
            delBtn.innerHTML = "✖";
            delBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
            delBtn.onclick = () => {
                const dt = getDT(inputId);
                const items = Array.from(dt.files);
                const idx = items.findIndex(f =>
                    f.name === wrapper.dataset.name &&
                    String(f.size) === wrapper.dataset.size &&
                    f.type === wrapper.dataset.type
                );
                if (idx > -1) dt.items.remove(idx);
                document.getElementById(inputId).files = dt.files;
                URL.revokeObjectURL(video.src);
                wrapper.remove();
            };

            wrapper.append(video, editBtn, delBtn);
            previewEl.appendChild(wrapper);
        }

        // ===== Handler video: akumulasi ke DataTransfer =====
        function handleVideoUpload(input, previewId) {
            const preview = document.getElementById(previewId);
            const dt = getDT(input.id);

            Array.from(input.files).forEach(file => {
                if (!isVideoFile(file)) return; // ← pakai pengecekan baru
                dt.items.add(file);
                addVideoPreview(preview, file, input.id);
            });

            input.files = dt.files;
        }

        // ========= PRELOAD media lama (mode edit) HANYA untuk tampilan ========
        // Catatan: preload TIDAK menambah file ke input, jadi tidak re-upload.

        const IS_EDIT = @json($isEdit ?? false);

        const PRELOAD = IS_EDIT ? {
            final: {
                urls: @json($project->final_product_urls ?? []),
                paths: @json($project->final_product_photos ?? []),
            },
            process: {
                urls: @json($project->design_process_urls ?? []),
                paths: @json($project->design_process_photos ?? []),
            },
            testing: {
                urls: @json($project->testing_photo_urls ?? []),
                paths: @json($project->testing_photos ?? []),
            },
            display: {
                urls: @json($project->display_photo_urls ?? []),
                paths: @json($project->display_photos ?? []),
            },
            poster: {
                urls: @json($project->poster_urls ?? []),
                paths: @json($project->poster_images ?? []),
            },
            video: {
                urls: @json($project->video_urls ?? []),
                paths: @json($project->videos ?? []),
            },
        } : null;


        function pushDeleteHidden(groupKey, rawPath) {
            // tambahkan input hidden delete_existing[groupKey][]
            const bucket = document.getElementById('deleteBucket');
            const inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = `delete_existing[${groupKey}][]`;
            inp.value = rawPath; // penting: path mentah, bukan URL
            bucket.appendChild(inp);
        }

        // makeImageThumb sekarang support callback onRemove (dipakai untuk display)
        function makeImageThumb(src, groupKey, rawPath, onRemove) {
            const wrapper = document.createElement("div");
            wrapper.className = "relative inline-block";
            const img = document.createElement("img");
            img.src = src;
            img.className = "max-h-32 object-contain rounded-lg border";
            const delBtn = document.createElement("button");
            delBtn.type = "button";
            delBtn.innerHTML = "✖";
            delBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
            delBtn.onclick = () => {
                pushDeleteHidden(groupKey, rawPath);
                wrapper.remove();
                if (typeof onRemove === 'function') onRemove();
            };
            wrapper.append(img, delBtn);
            return wrapper;
        }

        function makeVideoThumb(src, groupKey, rawPath) {
            const wrapper = document.createElement("div");
            wrapper.className = "relative inline-block";
            const video = document.createElement("video");
            video.src = src;
            video.controls = true;
            video.className = "h-40 w-64 object-contain rounded-lg border";
            const delBtn = document.createElement("button");
            delBtn.type = "button";
            delBtn.innerHTML = "✖";
            delBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
            delBtn.onclick = () => {
                pushDeleteHidden(groupKey, rawPath);
                wrapper.remove();
            };
            wrapper.append(video, delBtn);
            return wrapper;
        }


        if (IS_EDIT) {
            window.addEventListener('DOMContentLoaded', () => {
                (PRELOAD.final.urls || []).forEach((u, i) =>
                    document.getElementById('finalProductPreview')
                    .appendChild(makeImageThumb(u, 'final_product_photos', PRELOAD.final.paths[i]))
                );

                (PRELOAD.process.urls || []).forEach((u, i) =>
                    document.getElementById('designProcessPreview')
                    .appendChild(makeImageThumb(u, 'design_process_photos', PRELOAD.process.paths[i]))
                );

                (PRELOAD.testing.urls || []).forEach((u, i) =>
                    document.getElementById('testingphotoPreview')
                    .appendChild(makeImageThumb(u, 'testing_photos', PRELOAD.testing.paths[i]))
                );

                // ===== DISPLAY (single, preload & matikan tombol upload) =====
                const displayUrls = PRELOAD.display.urls || [];
                const displayPaths = PRELOAD.display.paths || [];
                const displayPreview = document.getElementById('displayphotoPreview');

                displayUrls.forEach((u, i) => {
                    displayPreview.appendChild(
                        makeImageThumb(u, 'display_photos', displayPaths[i], () => {
                            // kalau semua preview display sudah hilang, aktifkan upload lagi
                            if (displayPreview.childElementCount === 0) {
                                setDisplayUploadEnabled(true);
                                const input = document.getElementById('displayInput');
                                if (input) input.value = '';
                            }
                        })
                    );
                });

                if (displayUrls.length > 0) {
                    setDisplayUploadEnabled(false);
                }

                (PRELOAD.poster.urls || []).forEach((u, i) =>
                    document.getElementById('posterPreview')
                    .appendChild(makeImageThumb(u, 'poster_images', PRELOAD.poster.paths[i]))
                );

                (PRELOAD.video.urls || []).forEach((u, i) =>
                    document.getElementById('videoPreview')
                    .appendChild(makeVideoThumb(u, 'videos', PRELOAD.video.paths[i]))
                );
            });
        }
    </script>

    <script>
        // Cek apakah grup upload sudah punya file baru ATAU preview lama
        function hasFilesOrPreview(inputId, previewId) {
            const inp = document.getElementById(inputId);
            const prev = document.getElementById(previewId);

            const hasNew = inp && inp.files && inp.files.length > 0;
            const hasOld = prev && prev.childElementCount > 0;

            return hasNew || hasOld;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('projectForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                // daftar grup upload yang wajib terisi
                const groups = [{
                        input: 'finalProductInput',
                        preview: 'finalProductPreview'
                    },
                    {
                        input: 'designProcessInput',
                        preview: 'designProcessPreview'
                    },
                    {
                        input: 'testingInput',
                        preview: 'testingphotoPreview'
                    },
                    {
                        input: 'displayInput',
                        preview: 'displayphotoPreview'
                    },
                    {
                        input: 'posterInput',
                        preview: 'posterPreview'
                    },
                    {
                        input: 'videoInput',
                        preview: 'videoPreview'
                    },
                ];

                let firstMissing = null;

                groups.forEach(g => {
                    const isFilled = hasFilesOrPreview(g.input, g.preview);
                    const previewEl = document.getElementById(g.preview);

                    // tambahkan / hilangkan highlight merah
                    if (!isFilled && previewEl) {
                        previewEl.classList.add('ring-2', 'ring-red-400');
                        if (!firstMissing) firstMissing = previewEl;
                    } else if (previewEl) {
                        previewEl.classList.remove('ring-2', 'ring-red-400');
                    }
                });

                if (firstMissing) {
                    // blok submit & scroll ke section upload yang belum lengkap
                    e.preventDefault();
                    firstMissing.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });
    </script>

    <script>
        // Hapus ring merah setelah upload berhasil (preview terisi)
        document.addEventListener('DOMContentLoaded', () => {
            const PAIRS = [{
                    input: 'finalProductInput',
                    preview: 'finalProductPreview'
                },
                {
                    input: 'designProcessInput',
                    preview: 'designProcessPreview'
                },
                {
                    input: 'testingInput',
                    preview: 'testingphotoPreview'
                },
                {
                    input: 'displayInput',
                    preview: 'displayphotoPreview'
                },
                {
                    input: 'posterInput',
                    preview: 'posterPreview'
                },
                {
                    input: 'videoInput',
                    preview: 'videoPreview'
                },
            ];

            PAIRS.forEach(pair => {
                const inputEl = document.getElementById(pair.input);
                const previewEl = document.getElementById(pair.preview);
                if (!inputEl || !previewEl) return;

                inputEl.addEventListener('change', () => {
                    setTimeout(() => {
                        if (previewEl.childElementCount > 0) {
                            previewEl.classList.remove('ring-2', 'ring-red-400');
                        }
                    }, 50);
                });
            });
        });
    </script>




@endsection
