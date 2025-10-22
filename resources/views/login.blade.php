<DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <title>Login Page</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&amp;family=Roboto&amp;display=swap"
            rel="stylesheet" />
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
        <div class="px-6 sm:px-8 pt-6">
            <div class="flex items-center justify-between">
                <img src="/DWDP.png" alt="Logo" class="h-16 w-auto object-contain">
                <div class="flex items-center gap-2">
                    <a href="/aboutUS" class="italic text-black hover:text-gray-800 hover:underline transition">About
                        us</a>
                </div>
            </div>
        </div>

        <!-- SVG placeholder -->
        <!-- Simpel: tinggal pakai variabel di bawah di setiap src -->
        <!-- data:image/svg+xml;utf8,<svg ...> -->
        <!-- (sudah dipasang di semua <img> kartu di bawah) -->

        <main class="max-w-7xl mx-auto py-12 grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-12">
            <!-- Left column images -->
            <div class="flex flex-col gap-y-12">
                <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="No Project" class="w-full aspect-square object-cover" height="220"
                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'><rect width='100%25' height='100%25' fill='%23f3f4f6'/><text x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Poppins, Arial, sans-serif' font-size='64' fill='%239ca3af'>NO PROJECT</text></svg>"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600"></i>
                        <i class="fas fa-thumbs-down text-orange-500"></i>
                        <i class="fas fa-comment text-sky-500"></i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="No Project" class="w-full aspect-square object-cover" height="220"
                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'><rect width='100%25' height='100%25' fill='%23f3f4f6'/><text x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Poppins, Arial, sans-serif' font-size='64' fill='%239ca3af'>NO PROJECT</text></svg>"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600"></i>
                        <i class="fas fa-thumbs-down text-orange-500"></i>
                        <i class="fas fa-comment text-sky-500"></i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full" style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="No Project" class="w-full aspect-square object-cover" height="220"
                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'><rect width='100%25' height='100%25' fill='%23f3f4f6'/><text x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Poppins, Arial, sans-serif' font-size='64' fill='%239ca3af'>NO PROJECT</text></svg>"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600"></i>
                        <i class="fas fa-thumbs-down text-orange-500"></i>
                        <i class="fas fa-comment text-sky-500"></i>
                    </figcaption>
                </figure>
            </div>

            <div class="flex flex-col items-center">
                <!-- Center login form -->
                <section class="bg-[#d3ecfc] rounded-xl px-12 pt-10 pb-8 w-full shadow-md">
                    <h1 class="text-4xl font-extrabold text-center mb-6 leading-tight">
                        WELCOME <br /> BACK!
                    </h1>

                    {{-- alert error --}}
                    @if ($errors->any())
                        <div class="mb-4 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST" class="w-full space-y-5">
                        @csrf

                        {{-- Mahasiswa isi NIM; Dosen isi Email --}}
                        <div>
                            <input name="login" value="{{ old('login') }}"
                                class="w-full rounded-lg py-3 px-4 text-sm placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="NIM (Mahasiswa) / NIP (Dosen)" type="text" required />
                        </div>

                        <div>
                            <input name="password"
                                class="w-full rounded-lg py-3 px-4 text-sm placeholder-gray-400 shadow-md focus:outline-none focus:ring-2 focus:ring-sky-400"
                                placeholder="Password" type="password" required />
                            <p class="text-xs italic text-right mt-1 text-slate-600">
                                {{-- taruh link reset password kalau nanti dipakai --}}
                            </p>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="#"
                                class="italic text-sm text-gray-600 hover:text-gray-800 transition-opacity duration-200 opacity-70 hover:opacity-100">
                                Forgot password?
                            </a>
                        </div>

                        <button
                            class="w-full bg-sky-400 hover:bg-sky-500 text-white font-bold py-3 rounded-lg shadow-md transition-colors"
                            type="submit">
                            Login
                        </button>
                    </form>
                </section>

                <!-- Center bottom image with reactions and show more -->
                <div class="col-span-1 sm:col-span-2 flex flex-col items-center mt-6">
                    <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                        style="box-shadow: 2px 2px 6px #b8b8b8;">
                        <img alt="No Project" class="w-full h-[300px] object-cover" height="220"
                            src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 600'><rect width='100%25' height='100%25' fill='%23f3f4f6'/><text x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Poppins, Arial, sans-serif' font-size='72' fill='%239ca3af'>NO PROJECT</text></svg>"
                            width="320" />
                        <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                            <i class="fas fa-heart text-red-600"></i>
                            <i class="fas fa-thumbs-down text-orange-500"></i>
                            <i class="fas fa-comment text-sky-500"></i>
                        </figcaption>
                    </figure>
                    <a href="{{ route('gallery') }}"
                        class="mt-6 text-sm font-semibold italic text-slate-700 hover:text-slate-900">
                        SHOW MORE &raquo;&raquo;
                    </a>
                </div>
            </div>

            <!-- Right column images -->
            <div class="flex flex-col gap-y-12">
                <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                    style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="No Project" class="w-full aspect-square object-cover" height="220"
                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'><rect width='100%25' height='100%25' fill='%23f3f4f6'/><text x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Poppins, Arial, sans-serif' font-size='64' fill='%239ca3af'>NO PROJECT</text></svg>"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600"></i>
                        <i class="fas fa-thumbs-down text-orange-500"></i>
                        <i class="fas fa-comment text-sky-500"></i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                    style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="No Project" class="w-full aspect-square object-cover" height="220"
                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'><rect width='100%25' height='100%25' fill='%23f3f4f6'/><text x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Poppins, Arial, sans-serif' font-size='64' fill='%239ca3af'>NO PROJECT</text></svg>"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600"></i>
                        <i class="fas fa-thumbs-down text-orange-500"></i>
                        <i class="fas fa-comment text-sky-500"></i>
                    </figcaption>
                </figure>
                <figure class="bg-white shadow-md p-4 relative w-full max-w-3xl mx-auto"
                    style="box-shadow: 2px 2px 6px #b8b8b8;">
                    <img alt="No Project" class="w-full aspect-square object-cover" height="220"
                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'><rect width='100%25' height='100%25' fill='%23f3f4f6'/><text x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Poppins, Arial, sans-serif' font-size='64' fill='%239ca3af'>NO PROJECT</text></svg>"
                        width="320" />
                    <figcaption class="flex justify-center items-center space-x-4 mt-2 text-sm">
                        <i class="fas fa-heart text-red-600"></i>
                        <i class="fas fa-thumbs-down text-orange-500"></i>
                        <i class="fas fa-comment text-sky-500"></i>
                    </figcaption>
                </figure>
            </div>
        </main>
    </body>

    </html>
