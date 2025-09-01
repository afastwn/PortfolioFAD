{{-- resources/views/homeMhs.blade.php --}}
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">Home</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    <!-- Personal Works -->
    <section class="mb-10">
        <h2 class="text-xl font-extrabold mb-6">Personal Works</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div
                class="bg-white border border-gray-200 rounded-xl flex flex-col items-center justify-center aspect-square shadow hover:shadow-lg hover:scale-105 transition">
                <p class="text-6xl font-extrabold">14</p>
                <p class="font-semibold mt-2 text-lg">Total</p>
            </div>
            <div
                class="bg-white border border-gray-200 rounded-xl flex flex-col items-center justify-center aspect-square shadow hover:shadow-lg hover:scale-105 transition">
                <p class="text-6xl font-extrabold">7</p>
                <p class="font-semibold mt-2 text-lg">Published</p>
            </div>
            <div
                class="bg-white border border-gray-200 rounded-xl flex flex-col items-center justify-center aspect-square shadow hover:shadow-lg hover:scale-105 transition">
                <p class="text-6xl font-extrabold">7</p>
                <p class="font-semibold mt-2 text-lg">Draft</p>
            </div>
        </div>
    </section>

    <!-- Semester Progress -->
    <section class="mb-10">
        <h2 class="text-xl font-extrabold mb-3">Semester Progress</h2>
        <div class="w-full bg-gray-300 rounded-full h-6 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 h-6 rounded-full" style="width: 60%;"></div>
        </div>
        <p class="text-right font-semibold mt-1">60%</p>
    </section>

    <!-- Notification -->
    <section>
        <h2 class="text-2xl font-extrabold mb-4">Notification</h2>
        <ul class="space-y-3 text-base max-w-md">
            <li class="flex items-center gap-3 px-4 py-2 rounded-lg">
                <i class="fas fa-user-circle text-xl text-gray-600"></i>
                <p class="text-lg"><strong>Dina</strong> Commented your work</p>
            </li>
            <li class="flex items-center gap-3 px-4 py-2 rounded-lg">
                <i class="fas fa-user-circle text-xl text-gray-600"></i>
                <p class="text-lg"><strong>Unknown</strong> Commented your work</p>
            </li>
            <li class="flex items-center gap-3 px-4 py-2 rounded-lg">
                <i class="fas fa-user-circle text-xl text-gray-600"></i>
                <p class="text-lg"><strong>Unknown</strong> Like your work</p>
            </li>
            <li class="flex items-center gap-3 px-4 py-2 rounded-lg">
                <i class="fas fa-user-circle text-xl text-gray-600"></i>
                <p class="text-lg"><strong>Dina</strong> Commented your work</p>
            </li>
            <li class="flex items-center gap-3 px-4 py-2 rounded-lg">
                <i class="fas fa-user-circle text-xl text-gray-600"></i>
                <p class="text-lg"><strong>Unknown</strong> Commented your work</p>
            </li>
            <li class="flex items-center gap-3 px-4 py-2 rounded-lg">
                <i class="fas fa-user-circle text-xl text-gray-600"></i>
                <p class="text-lg"><strong>Unknown</strong> Like your work</p>
            </li>
        </ul>
    </section>
@endsection
