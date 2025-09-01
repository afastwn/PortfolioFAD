@extends('layouts.app')

@section('title', 'Add Project')

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
            <!-- Kotak Basic Info -->
            <div class="bg-white border rounded-xl shadow p-6 space-y-5">
                <h2 class="text-2xl font-extrabold">Basic Info</h2>

                <!-- Project Title -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Project Title</label>
                    <input type="text" class="w-full border rounded-lg p-2">
                </div>

                <!-- Category & Course -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Category</label>
                        <select class="w-full border rounded-lg p-2">
                            <option value=""></option>
                            <option>Home and Seating Furniture</option>
                            <option>Bedroom Furniture and Beds</option>
                            <option>Lamps and Luminaires</option>
                            <option>Lighting Systems</option>
                            <option>Household Appliances and Household Accessories</option>
                            <option>Kitchens and Kitchen Furniture</option>
                            <option>Kitchen Taps and Sinks</option>
                            <option>Kitchen Appliances and Kitchen Accessories</option>
                            <option>Cookware and Cooking Utensils</option>
                            <option>Tableware</option>
                            <option>Bathroom and Sanitary Equipment</option>
                            <option>Bathroom Taps and Shower Heads</option>
                            <option>Garden Furniture</option>
                            <option>Garden Appliances and Garden Equipment</option>
                            <option>Outdoor and Camping Equipment</option>
                            <option>Sports Equipment</option>
                            <option>Hobby and Leisure</option>
                            <option>Bicycles and Bicycle Accessories</option>
                            <option>Babies and Children</option>
                            <option>Personal Care, Wellness and Beauty</option>
                            <option>Fashion and Lifestyle Accessories</option>
                            <option>Luggage and Bags</option>
                            <option>Eyewear</option>
                            <option>Watches</option>
                            <option>Jewellery</option>
                            <option>Interior Architecture</option>
                            <option>Interior Design Elements</option>
                            <option>Urban Design</option>
                            <option>Materials and Surfaces</option>
                            <option>Office Furniture and Office Chairs</option>
                            <option>Office Supplies and Stationery</option>
                            <option>Tools</option>
                            <option>Heating and Air Conditioning Technology</option>
                            <option>Industrial Equipment, Machinery and Automation</option>
                            <option>Robotics</option>
                            <option>Medical Devices and Technology</option>
                            <option>Healthcare</option>
                            <option>Cars and Motorcycles</option>
                            <option>Motorhomes and Caravans</option>
                            <option>Watercraft</option>
                            <option>Trains and Planes</option>
                            <option>Commercial Vehicles</option>
                            <option>Vehicle Accessories</option>
                            <option>TV and Home Entertainment</option>
                            <option>Audio</option>
                            <option>Cameras and Camera Equipment</option>
                            <option>Drones and Action Cameras</option>
                            <option>Mobile Phones, Tablets and Wearables</option>
                            <option>Communication Technology</option>
                            <option>Computer and Information Technology</option>
                            <option>Gaming and Streaming</option>
                            <option>Packaging</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Course</label>
                        <select name="course" class="w-full border rounded-lg p-2">
                            <option value=""></option>
                            <option>Course 1</option>
                            <option>Course 2</option>
                            <option>Course 3</option>
                            <option>Course 4</option>
                            <option>Course 5</option>
                            <option>Course 6</option>
                            <option>Course 7</option>
                            <option>Course 8</option>
                        </select>
                    </div>
                </div>

                <!-- Client & Project Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Client</label>
                        <input type="text" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Project Date</label>
                        <input type="date" class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <!-- Design Brief -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Design Brief</label>
                    <textarea rows="3" placeholder="Concept / Abstract" class="w-full border rounded-lg p-2"></textarea>
                </div>

                <!-- Design Process -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Design Process</label>
                    <textarea rows="3" placeholder="Data, Sketch, Prototyping" class="w-full border rounded-lg p-2"></textarea>
                </div>

                <!-- Specifications -->
                <h3 class="text-lg font-bold">Specifications</h3>
                <div class="space-y-4">
                    <div>
                        <input type="text" placeholder="Material Specifications" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <input type="text" placeholder="Size Specifications" class="w-full border rounded-lg p-2">
                    </div>
                </div>
            </div>

            <!-- Tombol di bawah kotak Basic Info (masih di kolom kanan) -->
            <div class="grid grid-cols-2 gap-4">
                <a href="/myWorksMhs" class="w-full py-4 border rounded-lg text-center block">
                    Cancel
                </a>
                <button class="w-full py-4 bg-blue-600 text-white rounded-lg text-center">
                    Save Project
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

                    wrapper.appendChild(img);
                    wrapper.appendChild(editBtn);
                    wrapper.appendChild(deleteBtn);
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

                wrapper.appendChild(video);
                wrapper.appendChild(editBtn);
                wrapper.appendChild(deleteBtn);
                preview.appendChild(wrapper);
            });

            input.value = "";
        }
    </script>
@endsection
