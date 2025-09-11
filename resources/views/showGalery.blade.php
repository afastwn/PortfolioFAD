<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Galery</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[url('/BG.png')] bg-no-repeat bg-left-top bg-cover">

    <!-- WRAPPER: kotak putih besar -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 py-8">
        <div class="rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
            <!-- HEADER TOP: Logo (kiri) & HELLO (kanan) -->
            <div class="px-6 sm:px-8 pt-6">
                <div class="flex items-center justify-between">
                    <img src="/DWDP.png" alt="Logo" class="h-16 w-auto object-contain">
                    <div class="flex items-center gap-2">
                        <span class="text-4xl sm:text-5xl font-extrabold tracking-tight">HELLO!</span>
                        <span class="text-5xl sm:text-6xl">👋</span>
                    </div>
                </div>
                <!-- Garis agak transparan -->
                <div class="mt-4 border-t border-gray-300/60"></div>
            </div>

            <!-- BARIS JUDUL + SHOW ENTRIES -->
            <div class="px-6 sm:px-8 py-5">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl sm:text-2xl font-extrabold">Galery</h1>
                    <label class="flex items-center gap-2 text-sm">
                        Show
                        <select class="border rounded px-2 py-1">
                            <option>10</option>
                            <option>20</option>
                            <option>30</option>
                        </select>
                        entries
                    </label>
                </div>
            </div>

            <!-- GRID GALERY -->
            <div class="px-6 sm:px-8 pb-8">
                @php
                    // file gambar dari /public
                    $images = ['G1.png', 'G2.png', 'G3.png'];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for ($i = 0; $i < 15; $i++)
                        @php $image = $images[$i % count($images)]; @endphp
                        <figure class="bg-white p-4 shadow-sm" style="box-shadow: 2px 2px 6px #b8b8b8;">
                            <img src="{{ asset($image) }}" alt="Project {{ $i + 1 }}"
                                class="w-full aspect-square object-cover" loading="lazy">
                            <figcaption class="flex justify-center items-center space-x-6 mt-3 text-lg">
                                <i class="fas fa-heart text-red-600 cursor-pointer hover:scale-110 transition"></i>
                                <i
                                    class="fas fa-thumbs-down text-orange-500 cursor-pointer hover:scale-110 transition"></i>
                                <i class="fas fa-comment text-sky-500 cursor-pointer hover:scale-110 transition"></i>
                            </figcaption>
                        </figure>
                    @endfor
                </div>
            </div>
            <!-- /GRID -->
        </div>
    </div>
    <!-- SIGN IN button (sementara) -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 pb-6">
        <div class="flex justify-center">
            <a href="/login"
                class="inline-flex items-center justify-center w-40 h-11 rounded-md bg-blue-600 text-white font-extrabold tracking-wide hover:bg-blue-700">
                SIGN IN
            </a>
        </div>
    </div>

    <!-- /WRAPPER -->
    <footer class="mt-10 py-8 text-center text-xs text-gray-500">
        © {{ date('Y') }} FADUKDW
    </footer>
</body>

</html>
