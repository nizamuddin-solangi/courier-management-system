<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — CourierPro Premium</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-deep: #0B0C10;
            --bg-card: #1F2833;
            --text-main: #C5C6C7;
            --accent-primary: #66FCF1;
            --accent-secondary: #45A29E;
            --glass-bg: rgba(31, 40, 51, 0.7);
            --glass-border: rgba(102, 252, 241, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-deep);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
        }

        .premium-shadow {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-deep);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--accent-secondary);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-primary);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin.components.sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden sidebar-transition p-4 md:p-8">
            <!-- Topbar -->
            @include('admin.components.topbar')

            <!-- Page Content -->
            <main class="mt-8 animate-fade-in">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto pt-8 pb-4 text-center text-sm opacity-50">
                <p>&copy; {{ date('Y') }} CourierPro Premium MS. All rights reserved.</p>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
