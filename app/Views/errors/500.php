<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>500 - System Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #fb923c 0%, #db2777 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200 min-h-screen flex items-center justify-center p-6">
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-0 -left-10 w-96 h-96 bg-orange-500/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 -right-10 w-96 h-96 bg-pink-500/10 rounded-full blur-[120px]"></div>
    </div>
    <main class="max-w-xl w-full relative z-10 text-center">
        <div class="glass rounded-3xl p-12 shadow-2xl">
            <h1 class="text-9xl font-bold tracking-tighter mb-4 gradient-text">500</h1>
            <h2 class="text-3xl font-bold text-white mb-6">Something went wrong</h2>
            <p class="text-slate-400 mb-10 leading-relaxed">
                We've encountered an internal error. Our team (or this code) is working to fix it. Please try again
                later.
            </p>
            <a href="/"
                class="px-8 py-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all font-bold text-white shadow-xl inline-flex items-center gap-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Return Home
            </a>
        </div>
    </main>
</body>

</html>