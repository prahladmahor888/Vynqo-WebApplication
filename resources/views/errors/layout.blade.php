<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>@yield('title') — {{ $siteName ?? 'Sangfy' }}</title>
    <link rel="icon" type="image/png" href="{{ $siteFavicon ?? asset('assets/images/favicon.png') }}">
    <script src="{{ asset('assets/js/tailwind.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        :root, html, body { color-scheme: light !important; }
        body { font-family: 'Poppins', sans-serif; }
        .bg-grid-pattern {
            background-size: 32px 32px;
            background-image: 
                linear-gradient(to right, rgba(147, 51, 234, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(147, 51, 234, 0.05) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex items-center justify-center p-6 bg-grid-pattern relative overflow-hidden selection:bg-purple-600 selection:text-white">
    
    <!-- Ambient Glows -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-200/40 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-pink-200/40 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-md w-full bg-white/95 border border-slate-200 backdrop-blur-xl p-8 sm:p-10 rounded-3xl shadow-xl text-center space-y-6">
        
        <!-- Logo Icon -->
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-purple-50 border border-purple-100 p-2 text-brand-600 shadow-sm mx-auto">
            <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" alt="{{ $siteName ?? 'Sangfy' }} Logo" class="w-full h-full object-contain">
        </div>

        <div class="space-y-2">
            <span class="text-xs font-bold uppercase tracking-widest text-brand-600">@yield('code') Error</span>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">@yield('heading')</h1>
            <p class="text-sm text-slate-500 leading-relaxed">@yield('message')</p>
        </div>

        <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}" class="px-6 py-3 text-xs font-bold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 rounded-xl shadow-md transition">
                Return to Homepage
            </a>
            <a href="{{ url('/contact') }}" class="px-6 py-3 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition">
                Contact Support
            </a>
        </div>
    </div>

</body>
</html>
