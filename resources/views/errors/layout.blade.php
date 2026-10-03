<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Vynqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-grid-pattern {
            background-size: 32px 32px;
            background-image: 
                linear-gradient(to right, rgba(147, 51, 234, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(147, 51, 234, 0.05) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-6 bg-grid-pattern relative overflow-hidden selection:bg-purple-500 selection:text-white">
    
    <!-- Ambient Glows -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-pink-600/20 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-md w-full bg-slate-900/90 border border-slate-800 backdrop-blur-xl p-8 sm:p-10 rounded-3xl shadow-2xl text-center space-y-6">
        
        <!-- Logo Icon -->
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-pink-500 text-white shadow-lg shadow-purple-500/30 mx-auto">
            <span class="text-2xl font-black">V</span>
        </div>

        <div class="space-y-2">
            <span class="text-xs font-bold uppercase tracking-widest text-purple-400">@yield('code') Error</span>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">@yield('heading')</h1>
            <p class="text-sm text-slate-400 leading-relaxed">@yield('message')</p>
        </div>

        <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}" class="px-6 py-3 text-xs font-bold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 rounded-xl shadow-md transition">
                Return to Homepage
            </a>
            <a href="{{ url('/contact') }}" class="px-6 py-3 text-xs font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl transition">
                Contact Support
            </a>
        </div>
    </div>

</body>
</html>
