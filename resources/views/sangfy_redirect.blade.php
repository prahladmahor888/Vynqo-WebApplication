<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Sangfy</title>
    <meta property="og:title" content="{{ $title }} — Sangfy">
    <meta property="og:description" content="{{ $desc }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0B0F19;
            color: #F9FAFB;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .card {
            background: #111827;
            border: 1px solid #1F2937;
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }
        .logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #6366F1, #A855F7);
            border-radius: 18px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            color: #FFF;
        }
        h1 { font-size: 22px; margin-bottom: 8px; }
        p { color: #9CA3AF; font-size: 14px; margin-bottom: 24px; line-height: 1.5; }
        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #6366F1, #A855F7);
            color: #FFF;
            text-decoration: none;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: 0.2s;
        }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" alt="{{ $siteName ?? 'Sangfy' }}" style="width:100%;height:100%;object-fit:contain;padding:6px;">
        </div>
        <h1>{{ $title }}</h1>
        <p>{{ $desc }}</p>
        <a href="{{ $appUrl }}" class="btn" id="openBtn">
            <span>Open in {{ $siteName ?? 'Sangfy' }} App</span>
            <i class="fa-solid fa-rocket"></i>
        </a>
    </div>

    <script>
        // Auto-launch app if opened in mobile browser
        window.location.href = "{{ $appUrl }}";
    </script>
</body>
</html>
