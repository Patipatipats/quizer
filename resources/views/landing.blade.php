<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizer - AI Quiz Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Inter', sans-serif; } 
        /* Animasi kustom untuk background modern */
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
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-300 selection:text-indigo-900 overflow-x-hidden relative">

    <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob pointer-events-none -z-10"></div>
    <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob animation-delay-2000 pointer-events-none -z-10"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob animation-delay-4000 pointer-events-none -z-10"></div>

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 backdrop-blur-md bg-white/70 border-b border-slate-200/50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tighter flex items-center gap-2 group">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-500 group-hover:from-violet-500 group-hover:to-indigo-600 transition-all">Quizer</span>
                <span class="text-xl group-hover:-translate-y-1 transition-transform duration-300">🚀</span>
            </a>
            
            <div class="flex items-center gap-4 md:gap-6">
                <a href="{{ route('quiz.history') }}" class="hidden md:flex text-slate-600 hover:text-indigo-600 font-semibold text-sm transition items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Soal
                </a>
                <a href="{{ route('quiz.index') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-indigo-600 text-white font-medium text-sm rounded-full transition-all duration-300 shadow-md hover:shadow-indigo-500/30 hover:-translate-y-0.5">
                    Mulai Belajar
                </a>
            </div>
        </div>
    </nav>

    <section class="container mx-auto px-6 pt-36 pb-20 md:pt-48 md:pb-32 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100/50 text-indigo-700 text-xs md:text-sm font-bold mb-8 shadow-sm hover:shadow-md transition-shadow cursor-default">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
            </span>
            Ditenagai oleh Google Gemini 3.5 AI
        </div>
        
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold tracking-tight mb-8 leading-[1.1]">
            Ubah Modul Belajarmu <br class="hidden md:block">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-violet-500">Jadi Latihan Otomatis.</span>
        </h1>
        
        <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-2xl mx-auto leading-relaxed px-4 md:px-0">
            Tidak perlu pusing membuat soal manual. Unggah file PDF materimu, dan biarkan AI kami meracik 25 Pilihan Ganda & 5 Essay lengkap dengan kunci jawaban dalam hitungan detik.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 px-6 md:px-0">
            <a href="{{ route('quiz.index') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all duration-300 shadow-xl shadow-indigo-600/20 flex items-center justify-center gap-2 hover:-translate-y-1">
                Coba Quizer Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
            </a>
            <a href="#features" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-all border border-slate-200 flex items-center justify-center hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/50">
                Pelajari Fitur
            </a>
        </div>
    </section>

    <section id="features" class="bg-white py-24 md:py-32 border-t border-slate-100 relative z-10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 text-slate-900">Cara Kerja Quizer</h2>
                <p class="text-lg text-slate-500 max-w-xl mx-auto">3 langkah mudah untuk persiapan ujian yang lebih cerdas dan efisien tanpa buang waktu.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:border-indigo-100 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-slate-800">1. Unggah Modul</h3>
                    <p class="text-slate-500 leading-relaxed">Pilih file PDF materi pelajaran (maks. 25MB). Sistem kami akan mengekstrak teks materi secara otomatis dengan presisi tinggi.</p>
                </div>

                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:border-violet-100 hover:shadow-2xl hover:shadow-violet-500/10 transition-all duration-300">
                    <div class="w-14 h-14 bg-violet-100 text-violet-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-slate-800">2. AI Memproses</h3>
                    <p class="text-slate-500 leading-relaxed">Kecerdasan buatan menyusun 25 soal Pilihan Ganda (A-E) dan 5 soal Essay dengan tingkat kesulitan yang terukur sesuai konteks.</p>
                </div>

                <div class="group p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:bg-white hover:border-fuchsia-100 hover:shadow-2xl hover:shadow-fuchsia-500/10 transition-all duration-300">
                    <div class="w-14 h-14 bg-fuchsia-100 text-fuchsia-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-slate-800">3. Koreksi Otomatis</h3>
                    <p class="text-slate-500 leading-relaxed">Kerjakan langsung di dalam web. Dapatkan skor pilihan ganda seketika dan lihat panduan kunci untuk jawaban essay-mu.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-900">
        <div class="container mx-auto px-6 text-center flex flex-col items-center">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold text-white tracking-tighter mb-6 opacity-80 hover:opacity-100 transition">
                Quizer<span class="text-indigo-500">.</span>🚀
            </a>
            <p class="mb-2 font-medium">Dirancang & Dibangun oleh <span class="text-white font-bold">@patkepot</span></p>
            <p class="text-sm text-slate-500">© {{ date('Y') }} Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>