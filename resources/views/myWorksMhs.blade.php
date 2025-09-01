@extends('layouts.app')

@section('title', 'My Works')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">My Works</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    <section>
        <div class="grid grid-cols-3 gap-6">
            <!-- Baris 1 -->
            <!-- Project 1 -->
            <div
                class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden relative transition-transform duration-200 hover:scale-[1.02] aspect-square flex flex-col p-5">
                <img src="{{ asset('/G1.png') }}" alt="Project 1" class="w-full h-[78%] object-cover rounded-lg" loading="lazy">
                <div class="p-3 flex flex-col flex-1">
                    <h3 class="font-bold text-2xl">Project Title 1</h3>
                    <p class="text-lg italic text-gray-500 mb-1">Course Name</p>
                    <div class="flex justify-between items-center mt-auto">
                        <p class="text-sm font-semibold">Semester 1</p>
                        <div class="flex gap-2 text-blue-600">
                            <i class="fas fa-eye cursor-pointer"></i>
                            <i class="fas fa-pencil-alt cursor-pointer"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project 2 -->
            <div
                class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden relative transition-transform duration-200 hover:scale-[1.02] aspect-square flex flex-col p-5">
                <img src="{{ asset('/G2.png') }}" alt="Project 2" class="w-full h-[78%] object-cover rounded-lg"
                    loading="lazy">
                <div class="p-3 flex flex-col flex-1">
                    <h3 class="font-bold text-2xl">Project Title 2</h3>
                    <p class="text-lg italic text-gray-500 mb-1">Course Name</p>
                    <div class="flex justify-between items-center mt-auto">
                        <p class="text-sm font-semibold">Semester 2</p>
                        <div class="flex gap-2 text-blue-600">
                            <i class="fas fa-eye cursor-pointer"></i>
                            <i class="fas fa-pencil-alt cursor-pointer"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Project -->
            <a href="/addProjectMhs"
                class="bg-white rounded-xl shadow hover:shadow-lg flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-transform duration-200 hover:scale-[1.02] aspect-square">
                <div class="text-center">
                    <span class="text-xl font-bold">Add Project</span>
                    <div class="text-4xl font-bold mt-2">+</div>
                    <p class="text-sm font-semibold mt-2">Semester 3</p>
                </div>
            </a>


            <!-- Semester 4 - 8 -->
            @for ($i = 4; $i <= 8; $i++)
                <div
                    class="bg-white rounded-xl shadow flex flex-col items-center justify-center text-gray-400 p-4 aspect-square">
                    <i class="fas fa-lock text-3xl mb-2"></i>
                    <span class="font-semibold">Locked</span>
                    <p class="text-sm italic">Complete Semester {{ $i }}</p>
                    <p class="text-sm font-semibold mt-2">Semester {{ $i }}</p>
                </div>
            @endfor
        </div>
    </section>

@endsection
