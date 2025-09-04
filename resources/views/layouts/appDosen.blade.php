<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        h1,
        h2 {
            font-family: 'Montserrat', sans-serif;
        }

        /* Sidebar aktif */
        .active-link {
            position: relative;
            background-color: #ffffff;
            color: black;
            font-weight: 600;
            padding: 12px 16px;
            border-top-left-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
            box-shadow: -2px 2px 6px rgba(0, 0, 0, 0.1);
            overflow: visible;
        }

        .active-link::after {
            content: "";
            position: absolute;
            top: 0;
            left: 140px;
            right: -200px;
            width: 100px;
            height: 100%;
            background: white;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }
    </style>
</head>

<body class="relative min-h-screen overflow-x-hidden bg-[url('/BG.png')] bg-no-repeat bg-left-top bg-cover">

    <!-- Logo -->
    <div class="absolute -top-12 left-6 z-20 flex flex-col items-start">
        <img alt="Logo" src="/DWDP.png" class="w-[120px] h-[160px] object-contain mb-4" />
    </div>

    <!-- Sidebar -->
    <nav class="absolute top-0 left-0 min-h-screen w-48 bg-transparent flex flex-col pt-32 pb-8 px-4 space-y-2 text-xs">
        <a href="/dashboardDsn"
            class="flex items-center gap-2 text-[#6b8a99] font-medium hover:bg-white rounded-r-xl px-3 py-2 transition {{ request()->is('dashboardDsn') ? 'active-link' : '' }}">
            <i class="fas fa-th-large text-[#6b8a99] text-base"></i> Dashboard
        </a>
        <a href="/studentProfiling"
            class="flex items-center gap-2 text-[#6b8a99] font-medium hover:bg-white rounded-r-xl px-3 py-2 transition
          {{ request()->is('studentProfiling') || request()->is('studentProfiling/*') ? 'active-link' : '' }}">
            <i class="fas fa-folder text-[#6b8a99] text-base"></i> Student Profiling
        </a>
        <a href="/vPortfolio"
            class="flex items-center gap-2 text-[#6b8a99] font-medium hover:bg-white rounded-r-xl px-3 py-2 transition {{ request()->is('vPortfolio') ? 'active-link' : '' }}">
            <i class="fas fa-expand text-[#6b8a99] text-base"></i> View Portfolio
        </a>
        <a href="/profileDsn"
            class="flex items-center gap-2 text-[#6b8a99] font-medium hover:bg-white rounded-r-xl px-3 py-2 transition {{ request()->is('profileDsn') ? 'active-link' : '' }}">
            <i class="fas fa-user text-[#6b8a99] text-base"></i> Profile
        </a>
    </nav>


    <!-- Main Content -->
    <main class="ml-56 mr-8 mt-8 mb-8 p-8 pt-20 bg-white rounded-xl shadow">
        @yield('content')
    </main>
</body>

</html>
