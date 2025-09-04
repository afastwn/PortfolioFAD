@extends('layouts.appDosen')

@section('title', 'Students Profiling')

@section('content')
    <!-- Header -->
    <header class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h2 class="text-base sm:text-lg font-semibold tracking-wide">STUDENTS PROFILING</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    <!-- Controls + Search -->
    <div class="mt-5 mb-4 flex items-center justify-between">
        <!-- Left: show entries -->
        <div class="flex items-center gap-2 text-sm">
            <span>Show</span>
            <div class="relative">
                <select id="pageSize"
                    class="appearance-none h-9 pl-3 pr-8 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <i class="fas fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-500"></i>
            </div>
            <span>entries</span>
        </div>

        <!-- Right: search -->
        <div class="relative">
            <input id="searchInput" type="text" placeholder="Search..."
                class="w-64 h-10 rounded-xl border border-gray-300 pl-10 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>


    <!-- Table -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Students ID</th>
                        <th class="px-6 py-4 text-left font-semibold">Name</th>
                        <th class="px-6 py-4 text-left font-semibold">Category</th>
                        <th class="px-6 py-4 text-left font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{-- Dummy rows: ganti ke @foreach nanti --}}
                    @php
                        $rows = [
                            ['id' => '20462', 'name' => 'Matt Dickerson', 'cat' => 'Lighting Systems'],
                            ['id' => '18933', 'name' => 'Wiktoria', 'cat' => 'Sports Equipment'],
                            ['id' => '45169', 'name' => 'Trixie Byrd', 'cat' => 'Vehicle Accessories'],
                            ['id' => '73003', 'name' => 'Jun Redfern', 'cat' => 'Watercraft'],
                            ['id' => '58825', 'name' => 'Miriam Kidd', 'cat' => 'Robotics'],
                            ['id' => '44122', 'name' => 'Dominic', 'cat' => 'Office Supplies and Stationery'],
                            ['id' => '89094', 'name' => 'Shanice', 'cat' => 'Computer and Information Technology'],
                            ['id' => '85252', 'name' => 'Poppy-Rose', 'cat' => 'Gaming and Streaming'],
                            ['id' => '99001', 'name' => 'Aria', 'cat' => 'Gaming and Streaming'],
                            ['id' => '99002', 'name' => 'Liam', 'cat' => 'Watches'],
                            ['id' => '99003', 'name' => 'Noah', 'cat' => 'Sports Equipment'],
                        ];
                    @endphp

                    @foreach ($rows as $i => $r)
                        <tr class="{{ $i % 2 ? 'bg-indigo-50/50' : 'bg-white' }} hover:bg-indigo-50 transition">
                            <td class="px-6 py-4">{{ $r['id'] }}</td>
                            <td class="px-6 py-4">{{ $r['name'] }}</td>
                            <td class="px-6 py-4">{{ $r['cat'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <!-- Person biru: nanti untuk modal detail -->
                                    <a href="{{ route('showProfile', $r['id']) }}"
                                        class="text-blue-600 hover:text-blue-700">
                                        <i class="fas fa-user"></i>
                                    </a>
                                    <!-- Hapus (belum ada aksi) -->
                                    <button type="button" class="text-red-600 hover:text-red-700" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 text-xs text-gray-500 border-t">
            <span id="countInfo">Showing 0 entries</span>
        </div>
    </div>

    <!-- Tiny JS: filter + page size (client-side) -->
    <script>
        const rows = Array.from(document.querySelectorAll('#tableBody tr'));
        const search = document.getElementById('searchInput');
        const pageSize = document.getElementById('pageSize');
        const countInfo = document.getElementById('countInfo');

        function render() {
            const q = (search.value || '').toLowerCase();
            const size = parseInt(pageSize.value, 10);
            const filtered = rows.filter(tr => tr.innerText.toLowerCase().includes(q));

            rows.forEach(tr => tr.classList.add('hidden'));
            filtered.slice(0, size).forEach(tr => tr.classList.remove('hidden'));

            countInfo.textContent = `Showing ${Math.min(size, filtered.length)} of ${filtered.length} entries`;
        }
        search.addEventListener('input', render);
        pageSize.addEventListener('change', render);
        render();
    </script>
@endsection
