<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Soal - Quizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Inter', sans-serif; } 
        /* Animasi kustom untuk background modern (konsisten dengan halaman lain) */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col relative overflow-x-hidden selection:bg-indigo-200">

    <div class="fixed top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob pointer-events-none -z-10"></div>
    <div class="fixed top-0 -right-4 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob animation-delay-2000 pointer-events-none -z-10"></div>
    <div class="fixed -bottom-8 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob animation-delay-4000 pointer-events-none -z-10"></div>

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 backdrop-blur-md bg-white/70 border-b border-slate-200/50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tighter flex items-center gap-2 group">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-500 group-hover:from-violet-500 group-hover:to-indigo-600 transition-all">Quizer</span>
                <span class="text-xl group-hover:-translate-y-1 transition-transform duration-300">🚀</span>
            </a>
            <div class="flex items-center gap-4 md:gap-6">
                <a href="{{ route('home') }}" class="hidden sm:block text-slate-500 hover:text-indigo-600 font-medium text-sm transition">
                    Beranda
                </a>
                <a href="{{ route('quiz.index') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-indigo-600 text-white font-medium text-sm rounded-full transition-all duration-300 shadow-md hover:shadow-indigo-500/30 hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Buat Soal Baru
                </a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 pt-32 pb-16 flex-grow max-w-4xl relative z-10">
        
        <div class="mb-10 text-center md:text-left flex flex-col md:flex-row items-center gap-4">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center shrink-0">
                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-1">
                    Riwayat Ujian
                </h1>
                <p class="text-slate-500 text-sm md:text-base">Daftar arsip soal yang berhasil diekstrak dan diracik oleh AI dari modulmu.</p>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-5 mb-8 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="bg-red-100 text-red-600 p-2 rounded-full shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <p class="font-medium text-sm">{{ session('error') }}</p>
            </div>
        @endif

        @if(count($histories) > 0)
            <div class="grid gap-5">
                @foreach($histories as $item)
                    <div class="group bg-white/80 backdrop-blur-sm p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/60 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 hover:border-indigo-200 transition-all duration-300">
                        <div class="space-y-3 w-full md:w-3/4">
                            <div class="flex flex-wrap items-center gap-3 text-xs">
                                <span class="bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-md tracking-wide uppercase">
                                    Tersimpan
                                </span>
                                <span class="text-slate-500 font-medium flex items-center gap-1.5 bg-slate-100 px-3 py-1 rounded-md">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y • H:i') }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-slate-800 leading-snug break-words group-hover:text-indigo-600 transition-colors">
                                {{ $item->nama_file }}
                            </h3>
                            
                            <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    25 Pilihan Ganda
                                </span>
                                <span class="text-slate-300">|</span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    5 Soal Essay
                                </span>
                            </p>
                        </div>
                        
                        <div class="w-full md:w-auto shrink-0">
                            <a href="{{ route('quiz.showHistory', $item->id) }}" class="flex items-center justify-center gap-2 w-full px-6 py-3.5 bg-indigo-50 text-indigo-700 font-bold text-sm rounded-xl hover:bg-indigo-600 hover:text-white transition-colors duration-300 border border-indigo-100 hover:border-transparent">
                                Buka Soal
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white/60 backdrop-blur-sm rounded-3xl border border-dashed border-slate-300 p-8 shadow-sm">
                <div class="w-20 h-20 bg-white shadow-sm border border-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-3.586-3.586a1 1 0 00-1.414 0L12 14l-4-4-4 4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Peti Riwayat Kosong</h3>
                <p class="text-slate-500 text-base max-w-md mx-auto mb-8 leading-relaxed">Sepertinya kamu belum pernah membuat soal latihan. Yuk, unggah modul PDF pertamamu dan biarkan AI kami bekerja!</p>
                <a href="{{ route('quiz.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-all hover:-translate-y-0.5 shadow-md shadow-indigo-200">
                    Generate Soal Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </a>
            </div>
        @endif

    </main>

    <footer class="bg-slate-950 text-slate-400 py-8 text-center mt-auto border-t border-slate-900 relative z-20">
        <p class="text-sm mb-1 font-medium">Dirancang & Dibangun oleh <span class="text-white font-bold">@patkepot</span></p>
        <p class="text-xs text-slate-600">© {{ date('Y') }} Quizer. All rights reserved.</p>
    </footer>

</body>
</html>