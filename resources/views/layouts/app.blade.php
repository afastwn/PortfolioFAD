<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Montserrat', sans-serif; }
        h1, h2 { font-family: 'Montserrat', sans-serif; }

        /* Sidebar aktif */
        .active-link {
            position: relative;
            background-color: #ffffff;
            color: black;
            font-weight: 600;
            padding: 12px 16px;
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
            box-shadow: -2px 2px 6px rgba(0,0,0,0.1);
            overflow: visible;
        }
        .active-link::after {
            content: "";
            position: absolute;
            top: 0; right: -56px;
            width: 100px; height: 100%;
            background: white;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }
    </style>
</head>
<body class="relative min-h-screen overflow-x-hidden bg-[url('/BG.png')] bg-no-repeat bg-left-top bg-cover">


    <!-- Logo -->
    <div class="absolute top-6 left-6 z-20 flex flex-col items-start">
        <img alt="Logo" src="/ukdw.png" class="w-[60px] h-[80px] object-contain mb-4"/>
    </div>

    <!-- Sidebar -->
    <nav class="absolute top-0 left-0 min-h-screen w-64 bg-transparent flex flex-col pt-40 pb-10 px-6 space-y-4 text-lg">
        <a href="/homeMhs" class="flex items-center gap-3 text-[#6b8a99] font-semibold hover:bg-white rounded-r-3xl px-4 py-3 transition {{ request()->is('homeMhs') ? 'active-link' : '' }}">
            <i class="fas fa-th-large text-[#6b8a99] text-xl"></i> Home
        </a>
        <a href="/myWorksMhs" class="flex items-center gap-3 text-[#6b8a99] font-semibold hover:bg-white rounded-r-3xl px-4 py-3 transition {{ request()->is('myWorksMhs') ? 'active-link' : '' }}">
            <i class="fas fa-folder text-[#6b8a99] text-xl"></i> My Works
        </a>
        <a href="/all" class="flex items-center gap-3 text-[#6b8a99] font-semibold hover:bg-white rounded-r-3xl px-4 py-3 transition">
            <i class="fas fa-expand text-[#6b8a99] text-xl"></i> All Works
        </a>
        <a href="/profile" class="flex items-center gap-3 text-[#6b8a99] font-semibold hover:bg-white rounded-r-3xl px-4 py-3 transition">
            <i class="fas fa-user text-[#6b8a99] text-xl"></i> Profile
        </a>
    </nav>

    <!-- Main Content -->
    <main class="ml-72 mr-8 mt-8 mb-8 p-8 pt-20 bg-white rounded-xl shadow">
        @yield('content')
    </main>
</body>
</html>
