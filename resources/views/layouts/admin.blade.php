<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title') | SeaLedger</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-mist font-sans text-sm text-ink antialiased">
    @php
        $links = [
            ['route' => 'dashboard', 'match' => 'dashboard', 'label' => 'Dashboard', 'short' => 'Home', 'icon' => 'bi-grid-1x2'],
            ['route' => 'inventory.index', 'match' => 'inventory.*', 'label' => 'Fish Inventory', 'short' => 'Inventory', 'icon' => 'bi-box-seam'],
            ['route' => 'restocking.index', 'match' => 'restocking.*', 'label' => 'Restocking Plans', 'short' => 'Restock', 'icon' => 'bi-calendar2-check'],
            ['route' => 'sales.index', 'match' => 'sales.*', 'label' => 'Daily Sales', 'short' => 'Sales', 'icon' => 'bi-receipt'],
            ['route' => 'reports.index', 'match' => 'reports.*', 'label' => 'Reports & History', 'short' => 'Reports', 'icon' => 'bi-bar-chart-line'],
        ];
    @endphp

    {{-- Sidebar: original classes kept, just hidden below md --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-20 flex w-[260px] -translate-x-full flex-col border-r border-line bg-white px-4 py-6 transition-transform max-md:hidden md:w-[220px] md:translate-x-0 lg:w-[250px] print:hidden">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-0.5 px-2 pb-5 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="SeaLedger" class="block h-auto w-[130px]">
            <small class="mt-1 block text-[11px]">Fish Inventory &amp; Sales</small>
        </a>

        <p class="kicker mx-2.5 mb-2.5 mt-1">WORKSPACE</p>

        <nav class="grid gap-1">
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-3 rounded-[10px] px-3 py-3 font-semibold transition-colors hover:bg-soft hover:text-brand {{ request()->routeIs($link['match']) ? 'bg-soft text-brand' : 'text-black' }}">
                    <i class="bi {{ $link['icon'] }} text-lg"></i>
                    {{ $link['label'] }}
                    @if ($link['route'] === 'restocking.index')
                        <span class="ml-auto rounded-full bg-[#d2eeeb] px-[7px] py-0.5 text-[11px] text-brand-dark">{{ $pendingBadge }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="mt-auto grid gap-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-[10px] px-3 py-3 font-semibold text-black transition-colors hover:bg-soft hover:text-brand">
                <i class="bi bi-shop text-lg"></i>
                Customer view
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full cursor-pointer items-center gap-3 rounded-[10px] px-3 py-3 text-left font-semibold text-black transition-colors hover:bg-soft hover:text-brand">
                    <i class="bi bi-box-arrow-left text-lg"></i>
                    Log out
                </button>
            </form>
        </div>
    </aside>

    <div class="min-h-screen md:ml-[220px] lg:ml-[250px] print:ml-0">
        <header class="sticky top-0 z-10 flex h-[76px] items-center justify-between gap-3 border-b border-line bg-white px-4 md:px-[22px] lg:px-[34px] print:hidden">
            <div>
                <span class="text-[11px]">Workspace /</span>
                <strong>@yield('title')</strong>
            </div>

            <div class="flex items-center gap-2.5">
                <span class="grid size-9 place-items-center rounded-full bg-[#d9f1ee] font-extrabold text-brand">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="hidden sm:block">
                    <strong class="block text-xs">{{ auth()->user()->name }}</strong>
                    <small class="block text-[11px]">Store account</small>
                </span>

                {{-- Mobile-only: the sidebar's bottom actions --}}
                <div class="ml-1 flex items-center gap-1 md:hidden">
                    <a href="{{ route('home') }}" aria-label="Customer view" class="grid size-9 place-items-center rounded-full text-lg text-black hover:bg-soft hover:text-brand">
                        <i class="bi bi-shop"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" aria-label="Log out" class="grid size-9 cursor-pointer place-items-center rounded-full text-lg text-black hover:bg-soft hover:text-brand">
                            <i class="bi bi-box-arrow-left"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-[1600px] px-3.5 pb-28 pt-[22px] md:px-[22px] md:pb-[22px] lg:px-[34px] lg:pb-[30px] lg:pt-[30px] print:p-0">
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
                    <strong class="mb-1 block">Please fix the following:</strong>
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <footer class="flex flex-col justify-between gap-3 px-0.5 pb-1 pt-7 text-[10px] text-[#95a2a8] sm:flex-row">
                © 2026 SeaLedger · Fish Inventory and Sales Monitoring System
            </footer>
        </main>
    </div>

    {{-- Bottom navigation: mobile only --}}
    <nav class="fixed inset-x-0 bottom-0 z-20 grid grid-cols-5 border-t border-line bg-white pb-[env(safe-area-inset-bottom)] md:hidden print:hidden" aria-label="Main navigation">
        @foreach ($links as $link)
            @php $active = request()->routeIs($link['match']); @endphp
            <a href="{{ route($link['route']) }}"
               class="relative flex flex-col items-center gap-0.5 px-1 pb-2 pt-2.5 text-[10px] font-semibold transition-colors {{ $active ? 'text-brand' : 'text-black' }}">
                @if ($active)
                    <span class="absolute inset-x-5 top-0 h-0.5 rounded-b-full bg-brand"></span>
                @endif
                <span class="relative">
                    <i class="bi {{ $link['icon'] }} text-xl leading-none"></i>
                    @if ($link['route'] === 'restocking.index' && (int) $pendingBadge > 0)
                        <span class="absolute -right-2.5 -top-1.5 min-w-4 rounded-full bg-brand px-1 text-center text-[9px] leading-4 text-white">{{ $pendingBadge }}</span>
                    @endif
                </span>
                {{ $link['short'] }}
            </a>
        @endforeach
    </nav>

    <div id="appToast" class="pointer-events-none fixed bottom-24 right-4 z-[100] translate-y-3 rounded-[10px] bg-[#163b43] px-[18px] py-3 text-white opacity-0 shadow-xl transition duration-200 md:bottom-6 md:right-6">{{ session('success') }}</div>
</body>
</html>