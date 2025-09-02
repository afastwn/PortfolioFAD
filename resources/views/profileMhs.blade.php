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

    {{-- Grid 2 kolom, diposisikan di tengah --}}
    <div class="flex justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            {{-- Kolom kiri: Profil --}}
            <section class="flex justify-center">
                <div class="relative bg-white rounded-xl border shadow p-6 w-full max-w-sm pb-12">
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
                    <div class="mt-4 flex gap-2 flex-wrap">
                        <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded">Good</span>
                        <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded">Smart</span>
                        <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded">Fast</span>
                    </div>

                    {{-- Tombol edit --}}
                    <button
                        class="absolute bottom-4 right-4 bg-blue-600 text-white px-3 py-2 rounded-lg shadow hover:bg-blue-700 transition"
                        title="Edit profil">
                        <i class="fas fa-pen"></i>
                    </button>
                </div>
            </section>


            {{-- Kolom kanan --}}
            <section class="space-y-4 flex flex-col items-center">
                {{-- CAMPUS ACTIVITIES --}}
                <div class="relative bg-white rounded-xl border shadow p-6 pb-12 max-w-sm w-full">
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
                    <button
                        class="absolute bottom-4 right-4 bg-blue-600 text-white px-3 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        <i class="fas fa-pen"></i>
                    </button>
                </div>

                {{-- SKILLS --}}
                <div class="relative bg-white rounded-xl border shadow p-6 pb-12 max-w-sm w-full">
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
                    <button
                        class="absolute bottom-4 right-4 bg-blue-600 text-white px-3 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        <i class="fas fa-pen"></i>
                    </button>
                </div>

                {{-- SCHOOL --}}
                <div class="relative bg-white rounded-xl border shadow p-6 pb-12 max-w-sm w-full">
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
                    <button
                        class="absolute bottom-4 right-4 bg-blue-600 text-white px-3 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        <i class="fas fa-pen"></i>
                    </button>
                </div>
            </section>
        </div>
    </div>

@endsection
