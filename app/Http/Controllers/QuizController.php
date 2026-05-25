<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Http; // Kita ganti pakai HTTP bawaan Laravel
use Illuminate\Support\Facades\DB;   // Pastikan ini sudah di-import untuk query database

class QuizController extends Controller
{
    public function index()
    {
        return view('quiz');
    }

    public function generate(Request $request)
    {
        // 1. Validasi file PDF
        $request->validate([
            'modul' => 'required|mimes:pdf|max:25000', // Maksimal 25MB
        ]);

        try {
            // 2. Ekstrak teks dari PDF
            $parser = new Parser();
            $pdf = $parser->parseFile($request->file('modul')->path());
            $text = $pdf->getText();

            if (empty(trim($text))) {
                return back()->with('error', 'Gagal diproses! PDF sepertinya kosong atau berupa gambar hasil scan.');
            }

            // Bersihkan teks PDF
            $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
            $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);

            // Karena butuh 30 soal, kita lebarkan batas teks yang dibaca AI jadi 30.000 karakter
            $text = substr($text, 0, 30000); 

            // 3. Susun Prompt (Diubah untuk 25 PG (opsi A-E) dan 5 Essay)
            $prompt = 'Anda adalah guru pembuat soal ujian. Berdasarkan teks materi berikut, buatkan 25 soal pilihan ganda (dengan 5 opsi: a, b, c, d, e) dan 5 soal essay. 
            WAJIB KEMBALIKAN HANYA DALAM FORMAT OBJEK JSON MURNI TANPA MARKDOWN ATAU TEKS LAIN. 
            Struktur JSON harus persis seperti ini:
            {
              "pilihan_ganda": [
                {"soal": "Pertanyaan PG?", "opsi": {"a": "Ini", "b": "Itu", "c": "Sana", "d": "Sini", "e": "Situ"}, "jawaban_benar": "a"}
              ],
              "essay": [
                {"soal": "Pertanyaan Essay?", "jawaban_benar": "Kunci jawaban atau poin penting dari soal ini."}
              ]
            }
            Materi: ' . $text;

            // 4. Panggil API Gemini 
            set_time_limit(120); // Memberi waktu PHP maksimal 2 menit

            $apiKey = env('GEMINI_API_KEY');
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite:generateContent?key={$apiKey}";

            // --- TAMBAHKAN ->timeout(120) SEBELUM ->post() ---
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(120)->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                return back()->with('error', 'Gagal menghubungi API Google. Server sibuk, coba lagi nanti.');
            }

            $resultText = $response->json('candidates.0.content.parts.0.text');

            if (!$resultText) {
                return back()->with('error', 'AI tidak memberikan respons valid.');
            }

            // --- TRIK ANTI MENTAL: Ekstrak Object JSON (Sekarang pakai kurung kurawal '{') ---
            $start = strpos($resultText, '{');
            $end = strrpos($resultText, '}');

            if ($start !== false && $end !== false) {
                $resultText = substr($resultText, $start, $end - $start + 1);
            } else {
                return back()->with('error', 'AI gagal membuat format JSON yang sesuai.');
            }
            
            // 6. Decode ke array PHP
            $soalJson = json_decode(trim($resultText), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'Gagal memproses soal. Error: ' . json_last_error_msg());
            }

            // --- LOGIKA BARU: SIMPAN DATA KE TABEL HISTORY_SOAL ---
            DB::table('history_soal')->insert([
                'nama_file' => $request->file('modul')->getClientOriginalName(),
                'soal_json' => json_encode($soalJson),
                'created_at' => now(),
            ]);

            return view('quiz', ['soalArray' => $soalJson]);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // --- LOGIKA BARU: MENAMPILKAN DAFTAR HISTORY ---
    public function history()
    {
        // Mengambil semua riwayat dan diurutkan dari yang paling baru
        $histories = DB::table('history_soal')->orderBy('created_at', 'desc')->get();
        return view('history', ['histories' => $histories]);
    }

    // --- LOGIKA BARU: MENAMPILKAN DETAIL SOAL DARI HISTORY YANG DIPILIH ---
    public function showHistory($id)
    {
        $history = DB::table('history_soal')->where('id', $id)->first();
        
        if (!$history) {
            return redirect()->route('quiz.history')->with('error', 'Data riwayat tidak ditemukan.');
        }

        // Decode kembali teks JSON dari database menjadi array PHP
        $soalJson = json_decode($history->soal_json, true);
        
        // Memakai view 'quiz' yang sama, dibedakan dengan parameter 'is_history'
        return view('quiz', [
            'soalArray' => $soalJson, 
            'is_history' => true,
            'nama_file' => $history->nama_file
        ]);
    }
}