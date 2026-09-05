<?php

namespace App\Services\Peserta;

use App\Models\{Nilai, Pendaftaran};
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class TranskripParserService
{
    /**
     * Parse uploaded transcript file and populate scores into the Nilai table.
     *
     * @param Pendaftaran $pendaftaran
     * @param string $absoluteFilePath
     * @return array
     */
    public function parseAndPopulateNilai(Pendaftaran $pendaftaran, string $absoluteFilePath): array
    {
        if (!file_exists($absoluteFilePath)) {
            return [
                'success' => false,
                'message' => 'Berkas transkrip tidak ditemukan di server.',
                'matched_count' => 0,
                'matched' => [],
            ];
        }

        // 1. Ekstraksi teks dari berkas (PDF atau Gambar)
        $text = $this->extractTextFromFile($absoluteFilePath);

        if (empty(trim($text))) {
            Log::info("TranskripParserService: Tidak ada teks yang dapat diekstrak dari berkas {$absoluteFilePath}");
            return [
                'success' => false,
                'message' => 'Tidak ada teks yang dapat dibaca dari transkrip. Admin dapat menginput secara manual.',
                'matched_count' => 0,
                'matched' => [],
            ];
        }

        // 2. Ambil daftar materi yang sesuai dengan kegiatan
        $kegiatan = $pendaftaran->kegiatan;
        if (!$kegiatan) {
            return [
                'success' => false,
                'message' => 'Kegiatan pendaftaran tidak ditemukan.',
                'matched_count' => 0,
                'matched' => [],
            ];
        }

        $isPelatihan = $kegiatan->jenis_kegiatan === 'pelatihan';
        $materiList = [];

        if ($isPelatihan) {
            $materiList = $kegiatan->kegiatanPelatihan?->jadwalPelatihan?->pelatihan?->materi ?? collect();
        } else {
            $materiList = $kegiatan->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi?->materi ?? collect();
        }

        if ($materiList->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Tidak ada materi yang terdaftar pada kegiatan ini.',
                'matched_count' => 0,
                'matched' => [],
            ];
        }

        // 3. Cek apakah berkas merupakan Certification Exam Score Report (Certiport, Microsoft, Cisco, dll.)
        $examReport = $this->parseExamScoreReport($text);
        $matchedResults = [];
        $kolomMateri = $isPelatihan ? 'materi_pelatihan_id' : 'materi_sertifikasi_id';

        if ($examReport !== null && (!empty($examReport['sections']) || !empty($examReport['final_score']))) {
            Log::info("TranskripParserService: Terdeteksi format Exam Score Report (Certiport/Microsoft)", [
                'candidate'   => $examReport['candidate'] ?? null,
                'exam'        => $examReport['exam'] ?? null,
                'sections'    => count($examReport['sections']),
                'final_score' => $examReport['final_score'],
            ]);

            $matchedResults = $this->matchExamReportToMateri($materiList, $examReport, $pendaftaran, $kolomMateri);
        }

        // 4. Jika bukan Exam Report atau belum semua materi terisi, gunakan line-by-line matching akademik
        if (empty($matchedResults)) {
            // Pecah teks transkrip menjadi baris-baris
            $lines = preg_split('/\r\n|\r|\n/', $text);
            $cleanLines = [];
            foreach ($lines as $line) {
                $trimmed = trim(preg_replace('/\s+/', ' ', $line));
                if (!empty($trimmed)) {
                    $cleanLines[] = $trimmed;
                }
            }

            foreach ($materiList as $materi) {
                $judul = $materi->judul_materi ?? '';
                if (empty(trim($judul))) {
                    continue;
                }

                $score = $this->findScoreForMateri($judul, $cleanLines);

                if ($score !== null) {
                    Nilai::updateOrCreate(
                        [
                            'pendaftaran_id' => $pendaftaran->id,
                            $kolomMateri     => $materi->id,
                        ],
                        [
                            'nilai' => $score,
                        ]
                    );

                    $matchedResults[] = [
                        'materi_id' => $materi->id,
                        'judul'     => $judul,
                        'nilai'     => $score,
                    ];
                }
            }
        }

        Log::info("TranskripParserService: Berhasil mengekstrak " . count($matchedResults) . " nilai untuk pendaftaran #{$pendaftaran->id}");

        return [
            'success'       => count($matchedResults) > 0,
            'message'       => count($matchedResults) > 0
                ? count($matchedResults) . ' nilai materi berhasil terdeteksi otomatis dari transkrip.'
                : 'Transkrip terbaca namun nama mata kuliah belum ada yang cocok dengan materi kegiatan.',
            'matched_count' => count($matchedResults),
            'matched'       => $matchedResults,
        ];
    }

    /**
     * Ekstraksi teks dari berkas (PDF via Node parser / fallback PHP / AI fallback).
     */
    public function extractTextFromFile(string $filePath): string
    {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($ext === 'pdf') {
            // Engine 1: Local High-Speed Node.js Parser (pdf-parse)
            $text = $this->extractPdfWithNode($filePath);
            if (!empty(trim($text))) {
                return $text;
            }

            // Engine 1.1: Native PHP Stream Fallback
            $text = $this->extractPdfWithPhpStream($filePath);
            if (!empty(trim($text))) {
                return $text;
            }
        }

        // Engine 2: AI Vision Fallback (Gemini Flash) jika berkas gambar atau PDF scan tanpa layer teks
        $apiKey = env('GEMINI_API_KEY');
        if (!empty($apiKey)) {
            $aiText = $this->extractWithGeminiVision($filePath, $apiKey);
            if (!empty(trim($aiText))) {
                return $aiText;
            }
        }

        return '';
    }

    /**
     * Ekstraksi teks PDF menggunakan skrip Node.js lokal (0 delay, 0 cost).
     */
    protected function extractPdfWithNode(string $filePath): string
    {
        $scriptPath = base_path('resources/scripts/parse_pdf.cjs');
        if (!file_exists($scriptPath)) {
            return '';
        }

        // Cari executable node
        $nodePath = $this->findNodeBinary();
        if (!$nodePath) {
            return '';
        }

        try {
            $process = new Process([$nodePath, $scriptPath, $filePath]);
            $process->setTimeout(10);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::warning("TranskripParserService: Node script failed: " . $process->getErrorOutput());
                return '';
            }

            $output = $process->getOutput();
            // Ambil bagian JSON dari output
            if (preg_match('/\{[\s\S]*\}/', $output, $matches)) {
                $data = json_decode($matches[0], true);
                if (isset($data['status']) && $data['status'] === 'success') {
                    return $data['text'] ?? '';
                }
            }
        } catch (\Throwable $e) {
            Log::warning("TranskripParserService: Node execution error: " . $e->getMessage());
        }

        return '';
    }

    /**
     * Fallback pencarian path binary Node.js
     */
    protected function findNodeBinary(): ?string
    {
        $candidates = [
            '/Users/andi.ikhlass/.nvm/versions/node/v20.19.5/bin/node',
            '/usr/local/bin/node',
            '/opt/homebrew/bin/node',
            '/usr/bin/node',
        ];

        foreach ($candidates as $cand) {
            if (file_exists($cand) && is_executable($cand)) {
                return $cand;
            }
        }

        $which = trim((string)shell_exec('which node 2>/dev/null'));
        if (!empty($which) && file_exists($which)) {
            return $which;
        }

        return null;
    }

    /**
     * Ekstraksi teks PDF murni menggunakan PHP (membaca stream FlateDecode dasar).
     */
    protected function extractPdfWithPhpStream(string $filePath): string
    {
        try {
            $content = @file_get_contents($filePath);
            if (!$content) {
                return '';
            }

            // Cari semua stream terkompresi di dalam PDF
            preg_match_all('/stream[\r\n]+([\s\S]*?)[\r\n]+endstream/m', $content, $matches);
            $extractedText = '';

            foreach ($matches[1] as $stream) {
                $decompressed = @gzuncompress($stream);
                if ($decompressed === false) {
                    $decompressed = @gzinflate($stream);
                }

                if ($decompressed) {
                    // Ekstraksi teks dalam kurung (teks) Tj atau [(t)(e)(k)(s)] TJ
                    if (preg_match_all('/\((.*?)\)\s*Tj/s', $decompressed, $tjMatches)) {
                        $extractedText .= implode(' ', $tjMatches[1]) . "\n";
                    }
                    if (preg_match_all('/\[(.*?)\]\s*TJ/s', $decompressed, $tjMatches)) {
                        foreach ($tjMatches[1] as $arrayContent) {
                            if (preg_match_all('/\((.*?)\)/s', $arrayContent, $inner)) {
                                $extractedText .= implode('', $inner[1]) . ' ';
                            }
                        }
                        $extractedText .= "\n";
                    }
                }
            }

            return $extractedText;
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * Fallback OCR menggunakan Google Gemini 1.5 Flash untuk berkas gambar / PDF scan.
     */
    protected function extractWithGeminiVision(string $filePath, string $apiKey): string
    {
        try {
            $mimeType = mime_content_type($filePath) ?: 'application/pdf';
            $fileData = base64_encode(file_get_contents($filePath));

            $prompt = "Ekstrak semua baris transkrip nilai akademik dari dokumen ini. Tuliskan setiap mata kuliah beserta nilai angka atau nilai hurufnya per baris, contoh: Pemrograman Web: 85 (A). Tampilkan hanya teks transkripnya saja.";

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

            $response = Http::timeout(20)->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data'      => $fileData,
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
            }
        } catch (\Throwable $e) {
            Log::warning("TranskripParserService: Gemini Vision error: " . $e->getMessage());
        }

        return '';
    }

    /**
     * Mendeteksi dan mengekstrak dokumen hasil ujian sertifikasi (Certiport, Microsoft, Pearson VUE, dll.)
     */
    protected function parseExamScoreReport(string $text): ?array
    {
        $hasSectionAnalysis = stripos($text, 'SECTION ANALYSIS') !== false;
        $hasScoreReport = stripos($text, 'EXAM SCORE REPORT') !== false || stripos($text, 'SCORE REPORT') !== false;
        $hasFinalScore = stripos($text, 'FINAL SCORE') !== false || stripos($text, 'Your Score') !== false;

        if (!$hasSectionAnalysis && !$hasScoreReport && !$hasFinalScore) {
            return null;
        }

        $report = [
            'candidate'   => null,
            'exam'        => null,
            'sections'    => [],
            'final_score' => null,
            'outcome'     => null,
        ];

        // Ekstraksi Candidate Name
        if (preg_match('/CANDIDATE\s*\n+([^\n]+)/i', $text, $cMatch)) {
            $report['candidate'] = trim($cMatch[1]);
        }

        // Ekstraksi Exam Title
        if (preg_match('/EXAM\s*\n+([^\n]+(?:\n+[^\n]+)?)\s*Registration ID/i', $text, $eMatch)) {
            $report['exam'] = trim(preg_replace('/\s+/', ' ', $eMatch[1]));
        }

        // Ekstraksi Section Analysis (Kompetensi / Modul Ujian)
        if ($hasSectionAnalysis) {
            // Ambil blok teks antara SECTION ANALYSIS dan FINAL SCORE (atau akhir dokumen)
            if (preg_match('/SECTION ANALYSIS([\s\S]*?)(?:FINAL SCORE|OUTCOME|$)/i', $text, $saMatch)) {
                $block = $saMatch[1];
                // Pola: Judul [weight (XX-YY%)] XX%
                if (preg_match_all('/([^\d%]+?)(?:\s*\(\d+-\d+%\))?\s*(\d{1,3})%/i', $block, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $m) {
                        $title = trim(preg_replace('/\s+/', ' ', $m[1]));
                        $score = (float)$m[2];
                        if (!empty($title) && $score >= 0 && $score <= 100) {
                            $report['sections'][] = [
                                'title' => $title,
                                'score' => $score,
                            ];
                        }
                    }
                }
            }
        }

        // Ekstraksi Final Score
        if (preg_match('/Your Score\s*(\d{2,4})/i', $text, $fsMatch)) {
            $rawScore = (float)$fsMatch[1];
            // Jika skala 1000 (misal 820), skala ke 0-100 (82.0)
            $report['final_score'] = $rawScore > 100 ? round($rawScore / 10, 1) : $rawScore;
        }

        // Ekstraksi Outcome (Pass / Fail)
        if (preg_match('/OUTCOME\s*\n*([A-Za-z]+)/i', $text, $oMatch)) {
            $report['outcome'] = trim($oMatch[1]);
        }

        return $report;
    }

    /**
     * Mencocokkan hasil Exam Score Report dengan daftar materi kegiatan
     */
    protected function matchExamReportToMateri($materiList, array $report, Pendaftaran $pendaftaran, string $kolomMateri): array
    {
        $sections = $report['sections'] ?? [];
        $finalScore = $report['final_score'] ?? null;
        $matchedResults = [];

        // 1. Coba pencocokan berbasis kesamaan nama materi dengan nama section
        $usedSections = [];

        foreach ($materiList as $materi) {
            $judulMateri = $materi->judul_materi ?? '';
            $normJudul = $this->normalizeString($judulMateri);
            $judulTokens = $this->tokenize($normJudul);

            $bestScore = null;
            $bestMatchIdx = -1;
            $highestRating = 0;

            foreach ($sections as $idx => $sec) {
                if (in_array($idx, $usedSections)) continue;

                $normSec = $this->normalizeString($sec['title']);
                $secTokens = $this->tokenize($normSec);

                $matchedTokens = array_intersect($judulTokens, $secTokens);
                $tokenRatio = count($judulTokens) > 0 ? count($matchedTokens) / count($judulTokens) : 0;
                similar_text($normJudul, $normSec, $sim);

                $rating = max($tokenRatio, $sim / 100);
                if ($rating >= 0.40 && $rating > $highestRating) {
                    $highestRating = $rating;
                    $bestScore = $sec['score'];
                    $bestMatchIdx = $idx;
                }
            }

            if ($bestScore !== null) {
                $usedSections[] = $bestMatchIdx;
                Nilai::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id, $kolomMateri => $materi->id],
                    ['nilai' => $bestScore]
                );
                $matchedResults[] = [
                    'materi_id' => $materi->id,
                    'judul'     => $judulMateri,
                    'nilai'     => $bestScore,
                ];
            }
        }

        // 2. Jika tidak ada yang cocok secara nama namun jumlah materi sama dengan jumlah section
        // Petakan 1-to-1 sesuai urutan modul
        if (empty($matchedResults) && count($sections) > 0 && count($sections) === $materiList->count()) {
            foreach ($materiList as $i => $materi) {
                $sec = $sections[$i];
                Nilai::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id, $kolomMateri => $materi->id],
                    ['nilai' => $sec['score']]
                );
                $matchedResults[] = [
                    'materi_id' => $materi->id,
                    'judul'     => $materi->judul_materi,
                    'nilai'     => $sec['score'],
                ];
            }
        }

        // 3. Jika masih ada materi yang belum terisi dan ada final_score (Your Score)
        // Isi materi yang belum terisi dengan final_score
        if ($finalScore !== null && count($matchedResults) < $materiList->count()) {
            $filledMateriIds = array_column($matchedResults, 'materi_id');
            foreach ($materiList as $materi) {
                if (!in_array($materi->id, $filledMateriIds)) {
                    Nilai::updateOrCreate(
                        ['pendaftaran_id' => $pendaftaran->id, $kolomMateri => $materi->id],
                        ['nilai' => $finalScore]
                    );
                    $matchedResults[] = [
                        'materi_id' => $materi->id,
                        'judul'     => $materi->judul_materi,
                        'nilai'     => $finalScore,
                    ];
                }
            }
        }

        return $matchedResults;
    }

    /**
     * Mencari nilai untuk suatu materi dari baris-baris transkrip.
     */
    protected function findScoreForMateri(string $judulMateri, array $lines): ?float
    {
        $normalizedJudul = $this->normalizeString($judulMateri);
        $judulTokens = $this->tokenize($normalizedJudul);

        if (empty($judulTokens)) {
            return null;
        }

        $bestScore = null;
        $highestMatchRating = 0;

        foreach ($lines as $line) {
            $normalizedLine = $this->normalizeString($line);
            $lineTokens = $this->tokenize($normalizedLine);

            if (empty($lineTokens)) {
                continue;
            }

            // Hitung kecocokan token
            $matchedTokens = array_intersect($judulTokens, $lineTokens);
            $tokenRatio = count($matchedTokens) / count($judulTokens);

            // Cek substring langsung
            $substringMatch = str_contains($normalizedLine, $normalizedJudul);

            // Cek persentase kemiripan teks
            similar_text($normalizedJudul, $normalizedLine, $similarityPercent);

            $matchRating = 0;
            if ($substringMatch) {
                $matchRating = 1.0;
            } elseif ($tokenRatio >= 0.7) {
                $matchRating = $tokenRatio;
            } elseif ($similarityPercent >= 70) {
                $matchRating = $similarityPercent / 100;
            }

            // Jika baris ini cocok dengan materi
            if ($matchRating >= 0.65 && $matchRating > $highestMatchRating) {
                $extractedScore = $this->extractScoreFromLine($line);
                if ($extractedScore !== null) {
                    $highestMatchRating = $matchRating;
                    $bestScore = $extractedScore;
                }
            }
        }

        return $bestScore;
    }

    /**
     * Ekstraksi skor (angka 0–100 atau konversi huruf mutu) dari baris transkrip.
     */
    protected function extractScoreFromLine(string $line): ?float
    {
        // 1. Bersihkan kata-kata pengganggu (SKS, semester, kode mk, bobot gpa 0-4)
        $cleanLine = $line;
        
        // Hapus pola SKS, misal: "3 SKS", "4 sks", "3sks"
        $cleanLine = preg_replace('/\b\d+\s*sks\b/i', ' ', $cleanLine);
        // Hapus pola semester, misal: "Semester 4", "Sem 3"
        $cleanLine = preg_replace('/\bsem(?:ester)?\s*\d+\b/i', ' ', $cleanLine);
        // Hapus pola tahun, misal: "2023/2024"
        $cleanLine = preg_replace('/\b20\d{2}\/20\d{2}\b/', ' ', $cleanLine);

        // 2. Cari nilai angka eksplisit (prioritas angka puluhan 50–100, atau desimal)
        // Pola angka 0 - 100
        if (preg_match_all('/\b(100|[1-9]?[0-9](?:\.[0-9]+)?)\b/', $cleanLine, $numMatches)) {
            $candidates = array_map('floatval', $numMatches[1]);

            // Prioritaskan angka bernilai 50 - 100 (nilai ujian/akhir standar Indonesia)
            foreach ($candidates as $val) {
                if ($val >= 50 && $val <= 100) {
                    return $val;
                }
            }

            // Jika tidak ada di rentang 50-100, ambil angka valid pertama yang bukan 0 (misal 1-49)
            foreach ($candidates as $val) {
                // Abaikan jika hanya angka satuan 1-4 yang kemungkinan adalah bobot IPK (misal 4.00, 3.50)
                if ($val > 4.0 && $val <= 100) {
                    return $val;
                }
            }
        }

        // 3. Jika tidak ada angka eksplisit, cari nilai huruf mutu akademik (A, A+, A-, B+, B, dst.)
        if (preg_match('/\b([A-E][+-]?)(?!\w)/', $cleanLine, $gradeMatch)) {
            $grade = strtoupper(trim($gradeMatch[1]));
            return $this->convertGradeToNumber($grade);
        }

        return null;
    }

    /**
     * Konversi huruf mutu akademik standar ke nilai angka.
     */
    protected function convertGradeToNumber(string $grade): ?float
    {
        return match ($grade) {
            'A+', 'A' => 90.0,
            'A-'      => 85.0,
            'B+'      => 80.0,
            'B'       => 75.0,
            'B-'      => 70.0,
            'C+'      => 65.0,
            'C'       => 60.0,
            'D'       => 50.0,
            'E'       => 0.0,
            default   => null,
        };
    }

    /**
     * Normalisasi string untuk pencocokan judul materi.
     */
    protected function normalizeString(string $str): string
    {
        $str = strtolower($str);
        // Hapus kata-kata umum akademik / kerja yang tidak relevan dengan topik mata kuliah
        $stopwords = [
            'menerapkan', 'menggunakan', 'membuat', 'mengimplementasikan', 'menulis',
            'pengenalan', 'dasar-dasar', 'mata', 'kuliah', 'matakuliah', 'mk',
            'praktikum', 'praktek', 'teori', 'modul', 'kursus', 'dasar', 'lanjut',
            'konsep', 'arsitektur', 'manajemen', 'studi', 'kasus'
        ];
        $pattern = '/\b(' . implode('|', $stopwords) . ')\b/i';
        $str = preg_replace($pattern, '', $str);
        // Hapus karakter non-alfanumerik
        $str = preg_replace('/[^a-z0-9\s]/', ' ', $str);
        return trim(preg_replace('/\s+/', ' ', $str));
    }

    /**
     * Tokenize string menjadi kata-kata (panjang >= 3 huruf)
     */
    protected function tokenize(string $str): array
    {
        $words = explode(' ', $str);
        return array_values(array_filter($words, fn($w) => strlen($w) >= 3));
    }
}
