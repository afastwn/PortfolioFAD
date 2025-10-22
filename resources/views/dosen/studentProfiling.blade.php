@extends('layouts.appDosen')

@section('title', 'Students Profiling')

@section('content')
    <header class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h2 class="text-base sm:text-lg font-semibold tracking-wide">STUDENTS PROFILING</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    <form method="GET" class="mt-5 mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm">
            <span>Show</span>
            <div class="relative">
                <select name="size" onchange="this.form.submit()"
                    class="appearance-none h-9 pl-3 pr-8 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ([10, 25, 50, 100] as $opt)
                        <option value="{{ $opt }}" @selected(($pageSize ?? 10) == $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-500"></i>
            </div>
            <span>entries</span>
        </div>

        <div class="relative">
            <input name="q" value="{{ $q ?? '' }}" placeholder="Search name / NIM / category..."
                class="w-64 h-10 rounded-xl border border-gray-300 pl-10 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
    </form>

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
                <tbody>
                    @forelse ($students as $i => $u)
                        <tr class="{{ $i % 2 ? 'bg-indigo-50/50' : 'bg-white' }} hover:bg-indigo-50 transition">
                            <td class="px-6 py-4">{{ $u->nim ?? $u->id }}</td>
                            <td class="px-6 py-4">{{ $u->name_asli }}</td>
                            <td class="px-6 py-4">
                                {{ $u->categories_text ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('dosen.showProfile', $u->id) }}"
                                        class="text-blue-600 hover:text-blue-700" title="View profile & projects">
                                        <i class="fas fa-user"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 text-xs text-gray-500 border-t flex items-center justify-between">
            <span>
                @if ($students->total())
                    Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }} entries
                @else
                    Showing 0 entries
                @endif
            </span>
            <div>{{ $students->links() }}</div>
        </div>
    </div>
@endsection
