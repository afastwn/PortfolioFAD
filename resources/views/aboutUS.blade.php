<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>About Us</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3ede4;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="relative min-h-screen overflow-x-hidden bg-[url('/BG.png')] bg-no-repeat bg-left-top bg-cover">
    <!-- Logo kiri atas (tanpa link) -->
    <div class="absolute -top-8 left-6 z-20 flex flex-col items-start">
        <img alt="Logo" src="/DWDP.png" class="w-[120px] h-[160px] object-contain mb-4" />
    </div>

    <!-- Kartu putih besar di tengah -->
    <main class="max-w-xl mx-auto px-4 sm:px-6 pt-24 pb-10">
        <section class="relative bg-white rounded-2xl shadow-2xl ring-1 ring-gray-300/70 px-8 sm:px-12 py-10">
            <!-- Stiker kecil dekoratif -->
            <div class="absolute -top-5 -left-5 rotate-[-12deg]">
                <div class="bg-white rounded-md border border-gray-300 shadow px-2 py-1 text-lg">💌</div>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-center tracking-wide mb-8">ABOUT US</h1>

            <div class="text-[15px] sm:text-base leading-relaxed text-gray-900 space-y-5 font-bold text-justify">
                <p>
                    Aplikasi ini dibuat oleh Filistera Santoso dan Andreas Setiawan,
                    mahasiswa Program Studi Sistem Informasi Universitas Kristen Duta Wacana, sebagai wadah apresiasi
                    karya mahasiswa.
                </p>
                <p>
                    Kami percaya bahwa setiap karya layak untuk dilihat, diapresiasi, dan menjadi inspirasi bagi orang
                    lain.
                </p>
                <p>
                    Selain itu, aplikasi ini juga dikembangkan sebagai bagian dari program magang untuk meningkatkan
                    keterampilan
                    dalam desain dan pengembangan aplikasi.
                </p>
            </div>


            <!-- Copyright -->
            <div class="mt-10 flex items-center justify-center text-gray-400">
                <i class="far fa-copyright mr-2"></i>
                <span class="font-semibold">{{ date('Y') }} DuWa</span>
            </div>
        </section>

        <!-- Tombol kembali -->
        <div class="mt-8 flex justify-center">
            <a href="/utama"
                class="inline-flex items-center justify-center px-6 h-12 rounded-xl bg-sky-500 text-white font-bold shadow-md hover:bg-sky-600">
                Back to Home
            </a>
        </div>
    </main>

</body>

</html>
