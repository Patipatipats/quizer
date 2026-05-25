<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Soal - Quizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col relative selection:bg-indigo-200">

    <div id="loadingOverlay" class="fixed inset-0 bg-slate-900/80 z-[100] hidden flex-col items-center justify-center backdrop-blur-sm transition-all duration-300">
        <div class="relative w-20 h-20 mb-6">
            <div class="absolute inset-0 rounded-full border-t-4 border-b-4 border-indigo-500 animate-spin"></div>
            <div class="absolute inset-2 rounded-full border-l-4 border-r-4 border-violet-400 animate-spin flex items-center justify-center animation-reverse"></div>
            <span class="absolute inset-0 flex items-center justify-center text-2xl">🚀</span>
        </div>
        <h2 class="text-white text-2xl font-bold animate-pulse mb-2 tracking-tight">Meracik Soal...</h2>
        <p class="text-indigo-200 text-sm max-w-xs text-center font-medium">AI sedang memproses modul dan menyiapkan 30 pertanyaan. Mohon tunggu sekitar 30 detik.</p>
    </div>

    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tighter flex items-center gap-2 group">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-500">Quizer</span>
                <span class="text-xl group-hover:-translate-y-1 transition-transform duration-300">🚀</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-slate-500 hover:text-indigo-600 font-medium text-sm transition hidden sm:block">
                    Beranda
                </a>
                <a href="{{ route('quiz.history') }}" class="px-5 py-2.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-semibold text-sm rounded-full transition shadow-sm border border-indigo-100/50 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="hidden sm:inline">Riwayat Soal</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-12 flex-grow max-w-4xl">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-3">Ruang Belajar</h1>
            <p class="text-slate-500 text-lg">Hasilkan 25 Pilihan Ganda & 5 Essay secara otomatis</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-5 mb-8 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="bg-red-100 text-red-600 p-2 rounded-full shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <p class="font-bold mb-1">Validasi Dokumen Gagal!</p>
                    <ul class="list-disc ml-4 text-sm space-y-1 text-red-600">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-5 mb-8 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="bg-red-100 text-red-600 p-2 rounded-full shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="font-bold mb-0.5">Sistem Mengalami Kendala</p>
                    <p class="text-sm text-red-600">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(!isset($is_history))
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-6 md:p-8 mb-10 transition-shadow hover:shadow-md">
                <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </span>
                    Unggah Modul Pembelajaran
                </h3>
                <form id="uploadForm" action="{{ route('quiz.generate') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-center gap-4">
                    @csrf
                    <div class="w-full flex-grow relative">
                        <input type="file" name="modul" accept="application/pdf" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-indigo-50 hover:file:text-indigo-600 transition-all cursor-pointer border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 bg-slate-50">
                    </div>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md shadow-indigo-200 transition-all hover:-translate-y-0.5 whitespace-nowrap flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Mulai Proses AI
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-3xl p-6 md:p-8 mb-10 border border-emerald-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-sm">
                <div>
                    <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-md mb-2 tracking-wide uppercase">Mode Arsip Kunci Jawaban</span>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-800 break-all">{{ $nama_file }}</h2>
                    <p class="text-sm text-slate-500 mt-1">Halaman ini adalah mode baca. Kunci jawaban telah ditandai dengan warna hijau.</p>
                </div>
                <a href="{{ route('quiz.history') }}" class="whitespace-nowrap px-6 py-2.5 bg-white text-slate-700 font-semibold text-sm rounded-xl hover:bg-slate-50 transition border border-slate-200 shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        @endif

        @if(isset($soalArray) && isset($soalArray['pilihan_ganda']))
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 p-6 md:p-10">
                <form id="quizForm" action="#" method="POST">
                    
                    <div class="mb-14">
                        <div class="flex items-center gap-3 mb-8 border-b border-slate-100 pb-4">
                            <span class="flex items-center justify-center w-10 h-10 bg-indigo-600 text-white font-bold text-lg rounded-xl shadow-sm">A</span>
                            <h3 class="text-2xl font-bold text-slate-800">Pilihan Ganda</h3>
                        </div>
                        
                        <div class="space-y-10">
                            @foreach($soalArray['pilihan_ganda'] as $index => $item)
                                <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                                    <div class="flex gap-4">
                                        <span class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold text-sm">
                                            {{ $index + 1 }}
                                        </span>
                                        <div class="w-full">
                                            <p class="font-semibold text-slate-800 mb-5 text-lg leading-relaxed">
                                                {{ $item['soal'] }}
                                            </p>
                                            <div class="grid gap-3">
                                                @foreach($item['opsi'] as $key => $opsi)
                                                    @php
                                                        // Logika Blade: Cek apakah halaman ini adalah history DAN ini adalah jawaban yang benar
                                                        $isCorrect = (isset($is_history) && $is_history && $key === $item['jawaban_benar']);
                                                    @endphp
                                                    
                                                    <div class="relative flex items-center p-4 rounded-xl border transition-all cursor-pointer group 
                                                        {{ $isCorrect ? 'border-emerald-400 bg-emerald-50/80 shadow-sm' : 'border-slate-200 bg-white hover:border-indigo-300 hover:bg-indigo-50/30' }}">
                                                        
                                                        <input type="radio" id="pg_{{ $index }}_{{ $key }}" name="jawaban_pg[{{ $index }}]" value="{{ $key }}" class="w-5 h-5 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500 cursor-pointer peer" 
                                                            {{ isset($is_history) ? 'disabled' : '' }} 
                                                            {{ $isCorrect ? 'checked' : '' }}>
                                                            
                                                        <label for="pg_{{ $index }}_{{ $key }}" class="ml-4 cursor-pointer w-full select-none flex items-center peer-checked:font-medium transition-colors 
                                                            {{ $isCorrect ? 'text-emerald-800' : 'text-slate-700 peer-checked:text-indigo-900' }}" id="label_{{ $index }}_{{ $key }}">
                                                            <span class="w-7 font-bold transition-colors {{ $isCorrect ? 'text-emerald-600' : 'text-slate-400 group-hover:text-indigo-400 peer-checked:text-indigo-600' }}">{{ strtoupper($key) }}.</span> 
                                                            <span class="flex-grow">{{ $opsi }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="kunci-pg" data-soal="{{ $index }}" value="{{ $item['jawaban_benar'] }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if(isset($soalArray['essay']))
                        <div class="mb-12">
                            <div class="flex items-center gap-3 mb-8 border-b border-slate-100 pb-4">
                                <span class="flex items-center justify-center w-10 h-10 bg-violet-600 text-white font-bold text-lg rounded-xl shadow-sm">B</span>
                                <h3 class="text-2xl font-bold text-slate-800">Uraian Terbatas (Essay)</h3>
                            </div>
                            
                            <div class="space-y-8">
                                @foreach($soalArray['essay'] as $index => $item)
                                    <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                                        <div class="flex gap-4">
                                            <span class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-violet-100 text-violet-700 font-bold text-sm">
                                                {{ $index + 1 }}
                                            </span>
                                            <div class="w-full space-y-4">
                                                <p class="font-semibold text-slate-800 text-lg leading-relaxed">
                                                    {{ $item['soal'] }}
                                                </p>
                                                
                                                <textarea rows="3" class="w-full p-4 border border-slate-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-shadow resize-y 
                                                    {{ isset($is_history) ? 'bg-slate-100 text-slate-500 opacity-60' : 'text-slate-700 placeholder-slate-400' }}" 
                                                    placeholder="{{ isset($is_history) ? 'Teks jawaban hanya bisa diisi pada mode ujian aktif...' : 'Ketik uraian jawabanmu di sini...' }}" 
                                                    {{ isset($is_history) ? 'readonly' : '' }}></textarea>
                                                
                                                <div class="kunci-essay {{ isset($is_history) ? 'block' : 'hidden' }} relative overflow-hidden bg-emerald-50 border border-emerald-200 p-5 rounded-xl mt-4">
                                                    <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                                                    <p class="text-sm font-bold text-emerald-800 mb-2 flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Poin Kunci Jawaban:
                                                    </p>
                                                    <p class="text-emerald-700 text-sm md:text-base leading-relaxed">{{ $item['jawaban_benar'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <div id="hasilSkor" class="hidden mb-8 p-6 rounded-2xl font-bold text-center text-xl shadow-inner border"></div>

                    @if(!isset($is_history))
                        <div class="sticky bottom-6 z-40 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-slate-200">
                            <button type="button" onclick="cekJawaban()" id="btnCek" class="w-full py-4 bg-slate-900 hover:bg-indigo-600 text-white font-bold rounded-xl shadow-md text-lg transition-all duration-300 transform active:scale-[0.98]">
                                Kumpulkan & Koreksi Jawaban
                            </button>
                        </div>
                    @else
                        <div class="bg-slate-100 border border-slate-200 rounded-2xl p-6 text-center shadow-inner mt-10">
                            <h4 class="font-bold text-slate-700 text-lg mb-1">Akhir dari Arsip Modul Ujian</h4>
                            <p class="text-slate-500 text-sm">Gunakan soal dan kunci jawaban ini sebagai bahan latihan mandirimu.</p>
                        </div>
                    @endif

                </form>
            </div>
        @endif

    </main>

    <footer class="bg-slate-950 text-slate-400 py-8 text-center mt-auto border-t border-slate-900 relative z-20">
        <p class="text-sm mb-1 font-medium">Dirancang & Dibangun oleh <span class="text-white font-bold">@patkepot</span></p>
        <p class="text-xs text-slate-600">© {{ date('Y') }} Quizer. All rights reserved.</p>
    </footer>

    <script>
        const uploadForm = document.getElementById('uploadForm');
        if (uploadForm) {
            uploadForm.addEventListener('submit', function() {
                let overlay = document.getElementById('loadingOverlay');
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            });
        }

        function cekJawaban() {
            let scorePG = 0;
            let totalPG = {{ isset($soalArray['pilihan_ganda']) ? count($soalArray['pilihan_ganda']) : 0 }};
            let kunciPG = document.querySelectorAll('.kunci-pg');
            
            kunciPG.forEach(el => {
                let index = el.getAttribute('data-soal');
                let jawabanBenar = el.value;
                let radioName = 'jawaban_pg[' + index + ']';
                let jawabanUser = document.querySelector('input[name="' + radioName + '"]:checked');
                
                document.querySelectorAll('input[name="' + radioName + '"]').forEach(r => r.disabled = true);

                let labelBenar = document.getElementById('label_' + index + '_' + jawabanBenar);
                if (labelBenar) {
                    labelBenar.parentElement.classList.replace('border-slate-200', 'border-emerald-400');
                    labelBenar.parentElement.classList.replace('bg-white', 'bg-emerald-50');
                    labelBenar.classList.add('text-emerald-800');
                    labelBenar.querySelector('span:first-child').classList.replace('text-slate-400', 'text-emerald-600');
                }

                if (jawabanUser) {
                    if (jawabanUser.value === jawabanBenar) {
                        scorePG++;
                    } else {
                        let labelSalah = document.getElementById('label_' + index + '_' + jawabanUser.value);
                        if (labelSalah) {
                            labelSalah.parentElement.classList.replace('border-slate-200', 'border-red-300');
                            labelSalah.parentElement.classList.replace('bg-white', 'bg-red-50');
                            labelSalah.classList.add('text-red-700');
                            labelSalah.querySelector('span:first-child').classList.replace('text-slate-400', 'text-red-500');
                        }
                    }
                }
            });

            let hasilSkorDiv = document.getElementById('hasilSkor');
            hasilSkorDiv.classList.remove('hidden');
            
            let persentase = (scorePG / totalPG) * 100;
            if (persentase >= 80) {
                hasilSkorDiv.classList.add('bg-emerald-100', 'text-emerald-800', 'border-emerald-300');
            } else if (persentase >= 50) {
                hasilSkorDiv.classList.add('bg-amber-100', 'text-amber-800', 'border-amber-300');
            } else {
                hasilSkorDiv.classList.add('bg-red-100', 'text-red-800', 'border-red-300');
            }
            
            hasilSkorDiv.innerHTML = `Skor Pilihan Ganda: <span class="text-3xl">${scorePG}</span> / ${totalPG}<br><span class="text-sm font-medium opacity-80 mt-1 block">Gulir ke bawah untuk mencocokkan jawaban Essay.</span>`;

            document.querySelectorAll('.kunci-essay').forEach(el => {
                el.classList.remove('hidden');
            });
            document.querySelectorAll('textarea').forEach(el => {
                el.readOnly = true;
                el.classList.add('bg-slate-100', 'text-slate-500', 'border-slate-200');
            });

            let btnCek = document.getElementById('btnCek');
            btnCek.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Buat Soal Lainnya';
            btnCek.onclick = function() { window.location.href = "{{ route('quiz.index') }}"; };
            btnCek.classList.replace('bg-slate-900', 'bg-white');
            btnCek.classList.replace('text-white', 'text-slate-700');
            btnCek.classList.replace('hover:bg-indigo-600', 'hover:bg-slate-50');
            btnCek.classList.add('border', 'border-slate-300');
            
            window.scrollTo({ top: document.getElementById('hasilSkor').offsetTop - 100, behavior: 'smooth' });
        }
    </script>
</body>
</html>