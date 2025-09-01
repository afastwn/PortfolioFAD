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
    <section class="mt-6">
        <h2 class="text-3xl font-extrabold mb-4">Personal Works</h2>

        <div class="flex justify-center">
            <div class="grid grid-cols-2 gap-6 w-1/2">
                <!-- Box Total -->
                <div
                    class="bg-white border border-gray-200 rounded-xl flex flex-col items-center justify-center w-128 h-64 shadow hover:shadow-lg hover:scale-105 transition">
                    <p class="text-3xl font-extrabold">14</p>
                    <p class="font-medium mt-1">Total</p>
                </div>

                <!-- Box Published -->
                <div
                    class="bg-white border border-gray-200 rounded-xl flex flex-col items-center justify-center w-128 h-64 shadow hover:shadow-lg hover:scale-105 transition">
                    <p class="text-3xl font-extrabold">7</p>
                    <p class="font-medium mt-1">Published</p>
                </div>
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
