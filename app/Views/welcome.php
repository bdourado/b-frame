<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Welcome to <?= $title ?>">

    <title><?= $title ?></title>

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

<body class="bg-[#0f172a] text-slate-200 min-h-screen flex items-center justify-center p-6 overflow-x-hidden">
    <!-- Animated background blobs -->
    <div class="fixed top-0 -left-4 w-72 h-72 bg-blue-500/10 rounded-full blur-[120px]"></div>
    <div class="fixed bottom-0 -right-4 w-96 h-96 bg-purple-500/10 rounded-full blur-[120px]"></div>

    <main class="max-w-4xl w-full relative z-10 animate-fade-in">
        <div class="glass rounded-3xl p-8 md:p-12 shadow-2xl">
            <!-- Header section -->
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 gradient-text">
                    <?= $title ?>
                </h1>
                <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    <?= $text ?>
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div
                    class="p-6 rounded-2xl bg-white/5 border border-white/5 hover:border-blue-500/30 transition-all duration-300 group">
                    <div
                        class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center mb-4 text-blue-400 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">PHP 8.4 Ready</h3>
                    <p class="text-sm text-slate-400">Powered by the latest PHP features like Property Hooks and never
                        types.</p>
                </div>
                <div
                    class="p-6 rounded-2xl bg-white/5 border border-white/5 hover:border-purple-500/30 transition-all duration-300 group">
                    <div
                        class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center mb-4 text-purple-400 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Dockerized</h3>
                    <p class="text-sm text-slate-400">Zero-config setup with a pre-configured PHP 8.4-fpm environment.
                    </p>
                </div>
                <div
                    class="p-6 rounded-2xl bg-white/5 border border-white/5 hover:border-emerald-500/30 transition-all duration-300 group">
                    <div
                        class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center mb-4 text-emerald-400 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Eloquent Design</h3>
                    <p class="text-sm text-slate-400">Modern MVC pattern with optional DB connection for simple
                        micro-projects.</p>
                </div>
            </div>

            <!-- Footer / Author section -->
            <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t border-white/10 gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 p-0.5">
                        <div
                            class="w-full h-full rounded-full bg-[#0f172a] flex items-center justify-center border border-white/20 overflow-hidden">
                            <span class="font-bold text-lg"><?= substr($author, 0, 1) ?></span>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold"><?= $author ?></h4>
                        <p class="text-sm text-slate-500"><?= $role ?></p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="features"
                        class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all text-sm font-medium">View
                        Features</a>
                    <a href="<?= $linkedin ?>" target="_blank"
                        class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all text-sm font-medium">LinkedIn</a>
                    <a href="<?= $github ?>" target="_blank"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 transition-all text-sm font-medium shadow-lg shadow-blue-500/20">GitHub
                        Project</a>
                </div>
            </div>
        </div>

        <p class="text-center mt-8 text-slate-500 text-sm">
            Proudly crafted with BFrame & Tailwind CSS
        </p>
    </main>
</body>

</html>