<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Console') — Rapid Route Agent</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-deep: #0B0C10;
            --sidebar-bg: #1F2833;
            --accent-primary: #64ffda;
            --accent-secondary: #45A29E;
            --text-main: #C5C6C7;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-deep);
            color: var(--text-main);
        }

        .glass-panel {
            background: rgba(31, 40, 51, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .premium-shadow {
            box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.5);
        }

        .sidebar-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .form-notice {
            background: rgba(100, 255, 218, 0.05);
            border-left: 4px solid var(--accent-primary);
            padding: 1rem;
            border-radius: 0 1rem 1rem 0;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .error-msg, .live-error-msg {
            color: #ff4d4d;
            font-size: 10px;
            font-weight: 700;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: none;
        }

        input:invalid:not(:placeholder-shown) {
            border-color: #ff4d4d !important;
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

        .pulse-subtle { animation: pulse 3s infinite; }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); filter: blur(4px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
    </style>
</head>
<body class="antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('agent.components.sidebar')

        <!-- Main Content -->
        <div id="main-content" class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden sidebar-transition p-4 md:p-8">
            <!-- Topbar -->
            @include('agent.components.topbar')

            <!-- Page Content -->
            <main class="mt-8 animate-fade-in relative z-10">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto pt-12 pb-6 text-center text-[10px] uppercase tracking-[0.2em] text-[#45A29E] opacity-40 font-black">
                <p>&copy; {{ date('Y') }} Rapid Route Agent Node. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <script>
        // Global UI logic
    </script>
</body>
</html>
