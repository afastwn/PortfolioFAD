{{-- resources/views/homeMhs.blade.php --}}
@extends('layouts.appMhs')

@section('title', 'Home')

@section('content')
    <header class="flex justify-between items-center border-b border-gray-300 pb-3 mb-8">
        <h2 class="text-xl font-extrabold">Home</h2>
        <h1 class="text-2xl font-extrabold flex items-center gap-2">
            Hello, {{ explode(' ', Auth::user()->name_asli)[0] ?? 'User' }}! 👋
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
                    <p class="text-3xl font-extrabold">{{ $TOTAL_TARGET ?? 8 }}</p>
                    <p class="font-medium mt-1">Total</p>
                </div>

                <!-- Box Published -->
                <div
                    class="bg-white border border-gray-200 rounded-xl flex flex-col items-center justify-center w-128 h-64 shadow hover:shadow-lg hover:scale-105 transition">
                    <p class="text-3xl font-extrabold">{{ $uploadedCount ?? 0 }}</p>
                    <p class="font-medium mt-1">Published</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Semester Progress -->
    <section class="mb-10">
        <h2 class="text-xl font-extrabold mb-3">Semester Progress</h2>
        <div class="w-full bg-gray-300 rounded-full h-6 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 h-6 rounded-full"
                style="width: {{ $progressPercent ?? 0 }}%;"></div>
        </div>
        <p class="text-right font-semibold mt-1">{{ number_format($progressPercent ?? 0, 1) }}%</p>
    </section>

    <!-- Notification -->
    <section>
        <h2 class="text-2xl font-extrabold mb-4">Notification</h2>

        @php
            $totalNotif = isset($notifications) ? $notifications->count() : 0;
            $initial = 5;
        @endphp

        @if ($totalNotif > 0)
            <ul class="space-y-3 text-base max-w-md" id="notif-list">
                @foreach ($notifications as $i => $n)
                    <li
                        class="flex items-start gap-3 px-4 py-2 rounded-lg {{ $i >= $initial ? 'hidden js-more-notif' : '' }}">
                        <i class="fas fa-user-circle text-xl text-gray-600 mt-1"></i>
                        <div>
                            <p class="text-base leading-snug">
                                {!! nl2br(Str::of($n->message)->replace(':"', ':<br><span class="text-gray-600 italic">"')->append('</span>')) !!}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Tombol Show All / Show Less --}}
            @if ($totalNotif > $initial)
                <div class="max-w-md mt-3">
                    <button id="btn-show-all" class="text-sm font-semibold italic text-slate-700 hover:text-slate-900">
                        Show All ({{ $totalNotif - $initial }} more)
                    </button>
                    <button id="btn-show-less"
                        class="text-sm font-semibold italic text-slate-700 hover:text-slate-900 hidden">
                        Show Less
                    </button>
                </div>
            @endif
        @else
            <p class="text-sm text-gray-500">No notifications yet.</p>
        @endif
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const moreItems = document.querySelectorAll('.js-more-notif');
                const btnShowAll = document.getElementById('btn-show-all');
                const btnShowLess = document.getElementById('btn-show-less');

                if (btnShowAll) {
                    btnShowAll.addEventListener('click', function() {
                        moreItems.forEach(el => el.classList.remove('hidden'));
                        btnShowAll.classList.add('hidden');
                        btnShowLess.classList.remove('hidden');
                    });
                }

                if (btnShowLess) {
                    btnShowLess.addEventListener('click', function() {
                        moreItems.forEach(el => el.classList.add('hidden'));
                        btnShowLess.classList.add('hidden');
                        btnShowAll.classList.remove('hidden');
                    });
                }
            });
        </script>
    @endpush


@endsection
