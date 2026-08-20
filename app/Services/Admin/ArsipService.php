<?php

namespace App\Services\Admin;

use App\Models\ArsipKegiatan;
use Illuminate\Http\UploadedFile;

class ArsipService
{
    public function create(array $data): ArsipKegiatan
    {
        if (isset($data['berita_acara']) && $data['berita_acara'] instanceof UploadedFile && $data['berita_acara']->isValid()) {
            $data['berita_acara'] = $data['berita_acara']->store('arsip', 'public');
        }

        $docs = [];
        if (isset($data['uploaded_dokumentasi']) && is_array($data['uploaded_dokumentasi'])) {
            foreach ($data['uploaded_dokumentasi'] as $path) {
                if (is_string($path) && !empty($path)) {
                    $docs[] = $path;
                }
            }
        }
        if (isset($data['dokumentasi']) && is_array($data['dokumentasi'])) {
            foreach ($data['dokumentasi'] as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $path = \App\Helpers\ImageHelper::compressToWebp($file, 'arsip-dokumentasi');
                    if ($path) {
                        $docs[] = $path;
                    }
                }
            }
        }
        $data['dokumentasi'] = array_values(array_filter($docs));

        unset($data['_token'], $data['_method'], $data['uploaded_dokumentasi']);
        $arsip = ArsipKegiatan::create($data);
        if (empty($arsip->berita_acara)) {
            $this->generatePdfFile($arsip);
        }
        return $arsip;
    }

    public function generatePdfFile(ArsipKegiatan $arsip): string
    {
        $arsip->load(['kegiatan.kegiatanPelatihan.jadwalPelatihan.pelatihan', 'kegiatan.kegiatanSertifikasi.jadwalSertifikasi.sertifikasi']);
        $fileName = 'arsip/berita_acara_' . $arsip->hashid . '.pdf';

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.berita-acara-pdf', compact('arsip'))
                ->setPaper('a4', 'portrait');
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $pdf->output());
            if (empty($arsip->berita_acara)) {
                $arsip->update(['berita_acara' => $fileName]);
            }
        }

        return $fileName;
    }

    public function update(ArsipKegiatan $arsip, array $data): ArsipKegiatan
    {
        if (isset($data['berita_acara']) && $data['berita_acara'] instanceof UploadedFile && $data['berita_acara']->isValid()) {
            $data['berita_acara'] = $data['berita_acara']->store('arsip', 'public');
        }

        $existingDocs = $arsip->dokumentasi ?? [];
        
        // Hapus foto yang dipilih untuk dihapus
        if (isset($data['delete_dokumentasi']) && is_array($data['delete_dokumentasi'])) {
            $existingDocs = array_values(array_filter($existingDocs, fn($img) => !in_array($img, $data['delete_dokumentasi'])));
        }

        // Tambah foto dokumentasi baru (Pre-uploaded via AJAX)
        if (isset($data['uploaded_dokumentasi']) && is_array($data['uploaded_dokumentasi'])) {
            foreach ($data['uploaded_dokumentasi'] as $path) {
                if (is_string($path) && !empty($path)) {
                    $existingDocs[] = $path;
                }
            }
        }
        // Direct form upload fallback
        if (isset($data['dokumentasi']) && is_array($data['dokumentasi'])) {
            foreach ($data['dokumentasi'] as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $path = \App\Helpers\ImageHelper::compressToWebp($file, 'arsip-dokumentasi');
                    if ($path) {
                        $existingDocs[] = $path;
                    }
                }
            }
        }
        $data['dokumentasi'] = array_values(array_filter($existingDocs));

        unset($data['_token'], $data['_method'], $data['delete_dokumentasi'], $data['uploaded_dokumentasi']);
        $arsip->update($data);
        
        // Re-generate PDF file jika belum ada file fisik
        $cleanPath = preg_replace('/^storage\//', '', $arsip->berita_acara ?? '');
        if (empty($cleanPath) || !file_exists(storage_path('app/public/' . $cleanPath))) {
            $this->generatePdfFile($arsip);
        }

        return $arsip->fresh();
    }

    public function delete(ArsipKegiatan $arsip): void
    {
        $kegiatan = $arsip->kegiatan;
        $arsip->delete();

        if ($kegiatan) {
            foreach ($kegiatan->pendaftaran as $pendaftaran) {
                $pendaftaran->sertifikat()?->delete();
                $pendaftaran->nilai()->delete();
                $pendaftaran->pembayaran()?->delete();
                $pendaftaran->delete();
            }
            $kegiatan->biaya()?->delete();
            $kegiatan->kegiatanPelatihan()?->delete();
            $kegiatan->kegiatanSertifikasi()?->delete();
            $kegiatan->delete();
        }
    }

    public function autoArchiveCompleted(): void
    {
        $kegiatans = \App\Models\Kegiatan::passed()->doesntHave('arsip')->get();
        foreach ($kegiatans as $k) {
            $arsip = ArsipKegiatan::create([
                'kegiatan_id' => $k->id,
                'judul'       => $k->judul,
                'ringkasan'   => 'Kegiatan ' . $k->judul . ' telah selesai dilaksanakan.',
            ]);
            $this->generatePdfFile($arsip);
        }
    }
}
