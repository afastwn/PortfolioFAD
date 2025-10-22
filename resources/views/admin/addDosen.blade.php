@extends('layouts.appAdmin')

@section('title', 'Add Dosen')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800">HELLO! 👋</h1>

        <!-- Search Bar -->
        <div class="relative">
            <input type="text" id="customSearch" placeholder="Search..."
                class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#6b8a99] focus:outline-none" />
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
        </div>
    </div>

    <!-- Button Add Dosen -->
    <div class="mb-4">
        <button id="openModal"
            class="bg-[#bfe4d0] hover:bg-[#a8d6bf] text-gray-800 font-semibold px-4 py-2 rounded-lg shadow transition">
            + Add Dosen
        </button>
    </div>

    <!-- Dosen Table -->
    <div class="overflow-x-auto">
        <table id="dosenTable" class="min-w-full bg-white border border-gray-200 rounded-xl shadow-sm">
            <thead class="bg-[#f9fafb] border-b">
                <tr>
                    <th class="py-3 px-5 text-left font-semibold text-gray-600 text-sm">NIP/NIDN</th>
                    <th class="py-3 px-5 text-left font-semibold text-gray-600 text-sm">Name</th>
                    <th class="py-3 px-5 text-left font-semibold text-gray-600 text-sm">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dosenList = \App\Models\User::where('role', 'dosen')->orderBy('name_asli')->get();
                @endphp

                @foreach ($dosenList as $dosen)
                    @php
                        $nipNidn =
                            $dosen->nip && $dosen->nidn
                                ? $dosen->nip . ' / ' . $dosen->nidn
                                : ($dosen->nip ?:
                                ($dosen->nidn ?:
                                '-'));
                    @endphp
                    <tr class="{{ $loop->even ? 'bg-[#fafaff]' : 'bg-[#f8f6ff]' }} hover:bg-gray-50 transition">
                        <td class="py-3 px-5 text-gray-700">{{ $nipNidn }}</td>
                        <td class="py-3 px-5 text-gray-700">{{ $dosen->name_asli }}</td>
                        <td class="py-3 px-5">
                            <div class="flex items-center space-x-3">
                                {{-- <button class="text-[#0081a7] hover:opacity-70" title="View">
                                    <i class="fas fa-user"></i>
                                </button> --}}
                                <form action="{{ route('admin.user.destroy', $dosen->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus akun {{ $dosen->name_asli }} ({{ $dosen->nip }})?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#b00020] hover:opacity-70" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-96 p-6">
            <h3 class="text-center text-lg font-bold mb-4">PROFILE</h3>

            <form id="addDosenForm" method="POST" action="{{ route('admin.dosen.store') }}">
                @csrf
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label for="nip" class="block text-sm font-semibold mb-1">NIP</label>
                        <input type="text" id="nip" name="nip" maxlength="7"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#6b8a99] focus:outline-none">
                    </div>
                    <div>
                        <label for="nidn" class="block text-sm font-semibold mb-1">NIDN</label>
                        <input type="text" id="nidn" name="nidn" maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#6b8a99] focus:outline-none">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold mb-1">Full Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#6b8a99] focus:outline-none"
                        required>
                </div>

                <div class="mb-6 relative">
                    <label for="password" class="block text-sm font-semibold mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-lg p-2 pr-10 focus:ring-2 focus:ring-[#6b8a99] focus:outline-none"
                        required>

                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-8 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i id="eyeIcon" class="fas fa-eye-slash"></i>
                    </button>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="closeModal"
                        class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-[#6b8a99] hover:bg-[#5b7988] text-white px-4 py-2 rounded-lg text-sm shadow">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const modal = document.getElementById('modal');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        openModal.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        });

        togglePassword.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>

    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $(function() {
            const table = $('#dosenTable').DataTable({
                pageLength: 10,
                ordering: true,
                order: [
                    [0, 'asc']
                ],
                dom: 't<"flex justify-between items-center mt-4"lip>',
                columnDefs: [{
                    targets: 2,
                    orderable: false,
                    searchable: false
                }],
                language: {
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Tidak ditemukan",
                    paginate: {
                        first: "«",
                        last: "»",
                        next: "›",
                        previous: "‹"
                    }
                },
                initComplete: function(settings) {
                    // Jika tabel kosong, isi manual agar tidak error
                    if (settings.aoData.length === 0) {
                        $('#dosenTable tbody').html(`
                            <tr>
                                <td colspan="3" class="py-6 text-center text-gray-500 italic">
                                    Belum ada data dosen.
                                </td>
                            </tr>
                        `);
                    }
                }
            });

            // Custom search
            let t;
            $('#customSearch').on('input', function() {
                clearTimeout(t);
                const val = this.value;
                t = setTimeout(() => table.search(val).draw(), 250);
            });
        });
    </script>

    <style>
        #dosenTable tbody tr:nth-child(even) {
            background-color: #fafaff;
        }

        #dosenTable tbody tr:nth-child(odd) {
            background-color: #f8f6ff;
        }

        #dosenTable tbody tr:hover {
            background-color: #f3f4f6;
        }
    </style>
@endsection
