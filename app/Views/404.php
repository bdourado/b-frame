<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>404 - Page Not Found</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #f87171 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200 min-h-screen flex items-center justify-center p-6 overflow-x-hidden">
    <!-- Animated background blobs -->
    <div class="fixed top-0 -left-4 w-72 h-72 bg-red-500/10 rounded-full blur-[120px]"></div>
    <div class="fixed bottom-0 -right-4 w-96 h-96 bg-purple-500/10 rounded-full blur-[120px]"></div>

    <main class="max-w-xl w-full relative z-10 animate-fade-in text-center">
        <div class="glass rounded-3xl p-12 shadow-2xl">
            <h1 class="text-9xl font-bold tracking-tighter mb-4 gradient-text">404</h1>
            <h2 class="text-3xl font-bold text-white mb-6">Lost in space?</h2>
            <p class="text-slate-400 mb-10 leading-relaxed">
                The page you are looking for doesn't exist or has been moved to another dimension.
            </p>

            <a href="/"
                class="px-8 py-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all font-bold text-white shadow-xl inline-flex items-center gap-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Safety
            </a>
        </div>

        <p class="mt-8 text-slate-500 text-sm">
            BFrame &bull; Lost and Found
        </p>
    </main>
</body>

</html>