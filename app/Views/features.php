<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $title ?>">

    <title>
        <?= $title ?>
    </title>

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
            background: linear-gradient(135deg, #60a5fa 0%, #a855f7 100%);
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

<body class="bg-[#0f172a] text-slate-200 min-h-screen p-6 overflow-x-hidden">
    <!-- Animated background blobs -->
    <div class="fixed top-0 -left-4 w-72 h-72 bg-blue-500/10 rounded-full blur-[120px]"></div>
    <div class="fixed bottom-0 -right-4 w-96 h-96 bg-purple-500/10 rounded-full blur-[120px]"></div>

    <nav class="max-w-6xl mx-auto mb-12 relative z-10 animate-fade-in">
        <div class="flex items-center justify-between py-6">
            <a href="/" class="text-2xl font-bold gradient-text">BFrame</a>
            <div class="flex gap-6">
                <a href="/" class="text-slate-400 hover:text-white transition-colors">Home</a>
                <a href="#" class="text-white font-semibold">Features</a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto relative z-10 animate-fade-in">
        <header class="text-center mb-16 px-4">
            <h1 class="text-4xl md:text-6xl font-bold tracking-tight mb-6 text-white">
                Framework <span class="gradient-text">Features</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Everything you need to build lightweight, modern, and efficient PHP applications.
            </p>
        </header>

        <!-- Detailed Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            <?php foreach ($features as $feature): ?>
                <div class="glass p-8 rounded-3xl hover:border-blue-500/30 transition-all duration-300 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 flex items-center justify-center mb-6 text-blue-400 group-hover:scale-110 transition-transform">
                        <?php if ($feature['icon'] === 'code'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        <?php elseif ($feature['icon'] === 'container'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        <?php elseif ($feature['icon'] === 'route'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A2 2 0 013 15.483V4a2 2 0 012.724-1.847l9.276 4.638M15 4l5.447 2.724A2 2 0 0121 8.517V20l-5.447-2.724A2 2 0 0115 15.517V4zm-6 16V8l6-3v12l-6 3z" />
                            </svg>
                        <?php elseif ($feature['icon'] === 'database'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" />
                            </svg>
                        <?php elseif ($feature['icon'] === 'mvc'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">
                        <?= $feature['title'] ?>
                    </h3>
                    <p class="text-slate-400 leading-relaxed">
                        <?= $feature['description'] ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mb-20 animate-fade-in">
            <a href="/"
                class="px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-500 transition-all font-bold text-white shadow-xl shadow-blue-500/20 inline-flex items-center gap-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </main>

    <footer class="text-center py-12 border-t border-white/5 relative z-10">
        <p class="text-slate-500 text-sm">BFrame &copy;
            <?= date('Y') ?>
        </p>
    </footer>
</body>

</html>