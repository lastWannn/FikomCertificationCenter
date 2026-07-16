<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Peserta, Pendaftaran, Kegiatan, Nilai};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExportController extends Controller
{
    /** Export daftar semua peserta ke .xlsx */
    public function peserta()
    {
        if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\PesertaExport(), 'daftar-peserta-'.date('Y-m-d').'.xlsx'
            );
        }
        return $this->exportCsvPeserta();
    }

    private function exportCsvPeserta()
    {
        $rows   = Peserta::withCount('pendaftaran')->orderBy('nama')->get();
        $header = ['No','Nama','Email','No. HP','Kelamin','Instansi','Status Akun','Total Kegiatan','Terdaftar'];
        $data   = $rows->map(fn($r,$i) => [
            $i+1, $r->nama, $r->email, $r->no_hp,
            $r->kelamin==='L'?'Laki-laki':'Perempuan',
            $r->instansi??'-', ucfirst($r->status_akun??'aktif'),
            $r->pendaftaran_count,
            $r->created_at->format('d/m/Y'),
        ])->values()->toArray();

        return $this->streamCsv('daftar-peserta', $header, $data);
    }

    /** Export presensi peserta satu kegiatan */
    public function presensi(Kegiatan $kegiatan)
    {
        if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\PresensiExport($kegiatan), 'presensi-'.Str::slug($kegiatan->judul).'.xlsx'
            );
        }
        return $this->exportCsvPresensi($kegiatan);
    }

    private function exportCsvPresensi(Kegiatan $kegiatan)
    {
        $rows   = Pendaftaran::where('kegiatan_id',$kegiatan->id)->with('peserta')->get();
        $header = ['No','Nama','Email','No. HP','Instansi','Kelamin','Status Daftar','Status Kehadiran','Tgl Daftar'];
        $data   = $rows->map(fn($r,$i) => [
            $i+1, $r->peserta->nama, $r->peserta->email, $r->peserta->no_hp,
            $r->peserta->instansi??'-',
            $r->peserta->kelamin==='L'?'Laki-laki':'Perempuan',
            ucfirst(str_replace('_',' ',$r->status_pendaftaran)),
            ucfirst(str_replace('_',' ',$r->status_kehadiran??'belum')),
            $r->tgl_daftar->format('d/m/Y H:i'),
        ])->values()->toArray();

        return $this->streamCsv('presensi-'.Str::slug($kegiatan->judul), $header, $data);
    }

    /** Export semua pendaftaran */
    public function pendaftaran(Request $r)
    {
        $rows = Pendaftaran::with(['peserta','kegiatan','biaya','pembayaran'])
            ->when($r->kegiatan_id, fn($q) => $q->where('kegiatan_id',$r->kegiatan_id))
            ->orderBy('created_at','desc')
            ->get();

        $header = ['No','Nama Peserta','Email','Kegiatan','Jenis Biaya','Nominal','Status Daftar','Status Bayar','Tgl Daftar'];
        $data   = $rows->map(fn($row,$i) => [
            $i+1, $row->peserta->nama, $row->peserta->email,
            $row->kegiatan->judul,
            $row->biaya?->nama_jenis ?? 'Gratis',
            $row->biaya?->nominal ?? 0,
            ucfirst(str_replace('_',' ',$row->status_pendaftaran)),
            ucfirst(str_replace('_',' ',$row->pembayaran?->status_pembayaran ?? '-')),
            $row->tgl_daftar->format('d/m/Y H:i'),
        ])->values()->toArray();

        return $this->streamCsv('pendaftaran-'.date('Y-m-d'), $header, $data);
    }

    /** Export nilai peserta */
    public function nilai(Kegiatan $kegiatan)
    {
        $pendaftaran = Pendaftaran::where('kegiatan_id',$kegiatan->id)
            ->with(['peserta','nilai.materiPelatihan','nilai.materiSertifikasi'])
            ->where('status_pendaftaran','terdaftar')
            ->get();

        $header = ['No','Nama','Email','Rata-rata Nilai','Status Kehadiran'];
        $data   = $pendaftaran->map(fn($pd,$i) => [
            $i+1, $pd->peserta->nama, $pd->peserta->email,
            $pd->nilai->count() ? number_format($pd->nilai->avg('nilai'),2) : '-',
            ucfirst(str_replace('_',' ',$pd->status_kehadiran??'belum')),
        ])->values()->toArray();

        return $this->streamCsv('nilai-'.Str::slug($kegiatan->judul), $header, $data);
    }

    /** Export pembayaran */
    public function pembayaran(Request $r)
    {
        $rows = \App\Models\Pembayaran::with(['pendaftaran.peserta','pendaftaran.kegiatan'])
            ->when($r->status, fn($q) => $q->where('status_pembayaran',$r->status))
            ->orderBy('created_at','desc')
            ->get();

        $header = ['No','Kode Bayar','Nama Peserta','Email','Kegiatan','Jumlah','Status','Tgl Verifikasi'];
        $data   = $rows->map(fn($row,$i) => [
            $i+1, $row->kode_pembayaran,
            $row->pendaftaran->peserta->nama,
            $row->pendaftaran->peserta->email,
            $row->pendaftaran->kegiatan->judul,
            $row->jumlah_bayar,
            ucfirst(str_replace('_',' ',$row->status_pembayaran)),
            $row->tgl_verifikasi?->format('d/m/Y H:i') ?? '-',
        ])->values()->toArray();

        return $this->streamCsv('pembayaran-'.date('Y-m-d'), $header, $data);
    }

    /** Helper: stream CSV response */
    private function streamCsv(string $filename, array $header, array $rows)
    {
        $callback = function() use ($header, $rows) {
            $out = fopen('php://output', 'w');
            // BOM untuk Excel UTF-8
            fputs($out, "\xEF\xBB\xBF");
            fputcsv($out, $header, ';');
            foreach ($rows as $row) fputcsv($out, $row, ';');
            fclose($out);
        };

        return response()->streamDownload($callback, $filename.'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
