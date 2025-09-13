@extends('layouts.appMhs')

@php
    $isEdit = isset($mode) && $mode === 'edit';
    $project = isset($project) ? (object) $project : (object) [];
@endphp

@section('title', $isEdit ? 'Edit Project' : 'Add Project')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">My Works</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- ================= LEFT: UPLOAD SECTION ================= -->
        <div class="bg-white border rounded-xl shadow p-6 space-y-8">
            <h2 class="text-2xl font-extrabold">Upload Section</h2>

            {{-- Final Product --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Final Product Photo</p>
                    <button type="button" class="p-2 rounded-md border hover:bg-gray-50"
                        onclick="document.getElementById('finalProductInput').click()" title="Upload">
                        <i class="fas fa-upload"></i>
                    </button>
                </div>
                <input type="file" accept="image/*" multiple class="hidden" id="finalProductInput"
                    onchange="handleUpload(this, 'finalProductPreview')">

                <div class="bg-white border rounded-xl shadow p-4">
                    <div id="finalProductPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                </div>
            </div>

            {{-- Design Process --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Design Process Photos</p>
                    <button type="button" class="p-2 rounded-md border hover:bg-gray-50"
                        onclick="document.getElementById('designProcessInput').click()" title="Upload">
                        <i class="fas fa-upload"></i>
                    </button>
                </div>
                <input type="file" accept="image/*" multiple class="hidden" id="designProcessInput"
                    onchange="handleUpload(this, 'designProcessPreview')">

                <div class="bg-white border rounded-xl shadow p-4">
                    <div id="designProcessPreview" class="min-h-32 flex gap-2 flex-wrap"></div>
                </div>
            </div>

            {{-- Testing Photo --}}
            <div class="space-y-2">
                <p class="font-semibold">Testing Photo</p>
                <div class="bg-white border rounded-xl shadow p-4">
                    <label for="testingphotoInput"
                        class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 w-full h-32 cursor-pointer">
                        <span class="text-sm text-gray-500">Upload</span>
                    </label>
                    <input type="file" accept="image/*" class="hidden" id="testingphotoInput"
                        onchange="handleUpload(this, 'testingphotoPreview')">
                    <div id="testingphotoPreview" class="mt-2 flex gap-2 flex-wrap"></div>
                </div>
            </div>

            {{-- Display Photo --}}
            <div class="space-y-2">
                <p class="font-semibold">Display Photo</p>
                <div class="bg-white border rounded-xl shadow p-4">
                    <label for="displayphotoInput"
                        class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 w-full h-32 cursor-pointer">
                        <span class="text-sm text-gray-500">Upload</span>
                    </label>
                    <input type="file" accept="image/*" class="hidden" id="displayphotoInput"
                        onchange="handleUpload(this, 'displayphotoPreview')">
                    <div id="displayphotoPreview" class="mt-2 flex gap-2 flex-wrap"></div>
                </div>
            </div>

            {{-- Poster --}}
            <div class="space-y-2">
                <p class="font-semibold">Poster</p>
                <div class="bg-white border rounded-xl shadow p-4">
                    <label for="posterInput"
                        class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 w-full h-32 cursor-pointer">
                        <span class="text-sm text-gray-500">Upload</span>
                    </label>
                    <input type="file" accept="image/*" class="hidden" id="posterInput"
                        onchange="handleUpload(this, 'posterPreview')">
                    <div id="posterPreview" class="mt-2 flex gap-2 flex-wrap"></div>
                </div>
            </div>

            {{-- Video --}}
            <div class="space-y-2">
                <p class="font-semibold">Video</p>
                <div class="bg-white border rounded-xl shadow p-4">
                    <label for="videoInput"
                        class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 w-full h-32 cursor-pointer">
                        <span class="text-sm text-gray-500">Upload</span>
                    </label>
                    <input type="file" accept="video/*" class="hidden" id="videoInput"
                        onchange="handleVideoUpload(this, 'videoPreview')">
                    <div id="videoPreview" class="mt-2 flex gap-2 flex-wrap"></div>
                </div>
            </div>
        </div>

        <!-- ================= RIGHT: BASIC INFO + BUTTONS ================= -->
        <div class="flex flex-col gap-4">
            <div class="bg-white border rounded-xl shadow p-6 space-y-5">
                <h2 class="text-2xl font-extrabold">Basic Info</h2>

                <!-- Project Title -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Project Title</label>
                    <input type="text" class="w-full border rounded-lg p-2"
                        value="{{ $isEdit ? $project->title ?? '' : '' }}">
                </div>

                <!-- Category & Course -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Category</label>
                        @php $cat = $isEdit ? ($project->category ?? '') : ''; @endphp
                        <select class="w-full border rounded-lg p-2">
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
                        <label class="block text-sm font-semibold mb-1">Course</label>
                        @php $courseVal = $isEdit ? ($project->course ?? '') : ''; @endphp
                        <select name="course" class="w-full border rounded-lg p-2">
                            <option value=""></option>
                            @foreach (['Course 1', 'Course 2', 'Course 3', 'Course 4', 'Course 5', 'Course 6', 'Course 7', 'Course 8'] as $c)
                                <option value="{{ $c }}" {{ $courseVal === $c ? 'selected' : '' }}>
                                    {{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Client & Project Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Client</label>
                        <input type="text" class="w-full border rounded-lg p-2"
                            value="{{ $isEdit ? $project->client ?? '' : '' }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Project Date</label>
                        <input type="date" class="w-full border rounded-lg p-2"
                            value="{{ $isEdit ? $project->project_date ?? '' : '' }}">
                    </div>
                </div>

                <!-- Design Brief -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Design Brief</label>
                    <textarea rows="3" placeholder="Concept / Abstract" class="w-full border rounded-lg p-2">{{ $isEdit ? $project->design_brief ?? '' : '' }}</textarea>
                </div>

                <!-- Design Process -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Design Process</label>
                    <textarea rows="3" placeholder="Data, Sketch, Prototyping" class="w-full border rounded-lg p-2">{{ $isEdit ? $project->design_process ?? '' : '' }}</textarea>
                </div>

                <!-- Specifications -->
                <h3 class="text-lg font-bold">Specifications</h3>
                <div class="space-y-4">
                    <div>
                        <input type="text" placeholder="Material Specifications" class="w-full border rounded-lg p-2"
                            value="{{ $isEdit ? $project->spec_material ?? '' : '' }}">
                    </div>
                    <div>
                        <input type="text" placeholder="Size Specifications" class="w-full border rounded-lg p-2"
                            value="{{ $isEdit ? $project->spec_size ?? '' : '' }}">
                    </div>
                </div>
            </div>

            <!-- Tombol bawah -->
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('mhs.myworks') }}" class="w-full py-4 border rounded-lg text-center block">
                    Cancel
                </a>
                <button class="w-full py-4 bg-blue-600 text-white rounded-lg text-center">
                    {{ $isEdit ? 'Save Changes' : 'Save Project' }}
                </button>
            </div>
        </div>
    </div>

    <!-- =============== Scripts =============== -->
    <script>
        function handleUpload(input, previewId) {
            const preview = document.getElementById(previewId);
            const files = Array.from(input.files);

            files.forEach(file => {
                if (!file.type.startsWith("image/")) return;

                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "relative inline-block";

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "max-h-32 object-contain rounded-lg border";

                    const editBtn = document.createElement("button");
                    editBtn.innerHTML = "✏";
                    editBtn.className = "absolute top-1 left-1 bg-white p-1 text-xs rounded shadow";
                    editBtn.onclick = () => {
                        const newInput = document.createElement("input");
                        newInput.type = "file";
                        newInput.accept = "image/*";
                        newInput.onchange = ev => {
                            if (ev.target.files[0]) {
                                const reader2 = new FileReader();
                                reader2.onload = ev2 => {
                                    img.src = ev2.target.result;
                                };
                                reader2.readAsDataURL(ev.target.files[0]);
                            }
                        };
                        newInput.click();
                    };

                    const deleteBtn = document.createElement("button");
                    deleteBtn.innerHTML = "✖";
                    deleteBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
                    deleteBtn.onclick = () => wrapper.remove();

                    wrapper.append(img, editBtn, deleteBtn);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });

            input.value = "";
        }

        function handleVideoUpload(input, previewId) {
            const preview = document.getElementById(previewId);
            const files = Array.from(input.files);

            files.forEach(file => {
                if (!file.type.startsWith("video/")) return;

                const url = URL.createObjectURL(file);
                const wrapper = document.createElement("div");
                wrapper.className = "relative inline-block";

                const video = document.createElement("video");
                video.src = url;
                video.controls = true;
                video.className = "max-h-40 max-w-xs object-contain rounded-lg border";

                const editBtn = document.createElement("button");
                editBtn.innerHTML = "✏";
                editBtn.className = "absolute top-1 left-1 bg-white p-1 text-xs rounded shadow";
                editBtn.onclick = () => {
                    const newInput = document.createElement("input");
                    newInput.type = "file";
                    newInput.accept = "video/*";
                    newInput.onchange = ev => {
                        if (ev.target.files[0]) {
                            const newUrl = URL.createObjectURL(ev.target.files[0]);
                            URL.revokeObjectURL(video.src);
                            video.src = newUrl;
                        }
                    };
                    newInput.click();
                };

                const deleteBtn = document.createElement("button");
                deleteBtn.innerHTML = "✖";
                deleteBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
                deleteBtn.onclick = () => {
                    URL.revokeObjectURL(video.src);
                    wrapper.remove();
                };

                wrapper.append(video, editBtn, deleteBtn);
                preview.appendChild(wrapper);
            });

            input.value = "";
        }

        // ========= PRELOAD media lama kalau edit =========
        const IS_EDIT = @json($isEdit);
        const PRELOAD = IS_EDIT ? {
            final: @json($project->final_product_urls ?? []),
            process: @json($project->design_process_urls ?? []),
            testing: @json($project->testing_photo_urls ?? []),
            display: @json($project->display_photo_urls ?? []),
            poster: @json($project->poster_urls ?? []),
            video: @json($project->video_urls ?? []),
        } : null;

        function makeImageThumb(src) {
            const wrapper = document.createElement("div");
            wrapper.className = "relative inline-block";
            const img = document.createElement("img");
            img.src = src;
            img.className = "max-h-32 object-contain rounded-lg border";
            const editBtn = document.createElement("button");
            editBtn.innerHTML = "✏";
            editBtn.className = "absolute top-1 left-1 bg-white p-1 text-xs rounded shadow";
            editBtn.onclick = () => {
                const i = document.createElement("input");
                i.type = "file";
                i.accept = "image/*";
                i.onchange = ev => {
                    if (ev.target.files[0]) {
                        const r = new FileReader();
                        r.onload = e2 => {
                            img.src = e2.target.result;
                        };
                        r.readAsDataURL(ev.target.files[0]);
                    }
                };
                i.click();
            };
            const delBtn = document.createElement("button");
            delBtn.innerHTML = "✖";
            delBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
            delBtn.onclick = () => wrapper.remove();
            wrapper.append(img, editBtn, delBtn);
            return wrapper;
        }

        function makeVideoThumb(src) {
            const wrapper = document.createElement("div");
            wrapper.className = "relative inline-block";
            const video = document.createElement("video");
            video.src = src;
            video.controls = true;
            video.className = "max-h-40 max-w-xs object-contain rounded-lg border";
            const delBtn = document.createElement("button");
            delBtn.innerHTML = "✖";
            delBtn.className = "absolute top-1 right-1 bg-white p-1 text-xs rounded shadow";
            delBtn.onclick = () => wrapper.remove();
            wrapper.append(video, delBtn);
            return wrapper;
        }

        if (IS_EDIT) {
            window.addEventListener('DOMContentLoaded', () => {
                (PRELOAD.final || []).forEach(u => document.getElementById('finalProductPreview').appendChild(
                    makeImageThumb(u)));
                (PRELOAD.process || []).forEach(u => document.getElementById('designProcessPreview').appendChild(
                    makeImageThumb(u)));
                (PRELOAD.testing || []).forEach(u => document.getElementById('testingphotoPreview').appendChild(
                    makeImageThumb(u)));
                (PRELOAD.display || []).forEach(u => document.getElementById('displayphotoPreview').appendChild(
                    makeImageThumb(u)));
                (PRELOAD.poster || []).forEach(u => document.getElementById('posterPreview').appendChild(
                    makeImageThumb(u)));
                (PRELOAD.video || []).forEach(u => document.getElementById('videoPreview').appendChild(
                    makeVideoThumb(u)));
            });
        }
    </script>
@endsection
