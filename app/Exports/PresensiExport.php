<?php
namespace App\Exports;

use App\Models\{Kegiatan, Pendaftaran};
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\{Fill, Alignment};

class PresensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    public function __construct(private Kegiatan $kegiatan) {}

    public function title(): string { return 'Presensi'; }

    public function collection()
    {
        return Pendaftaran::where('kegiatan_id', $this->kegiatan->id)
            ->with('peserta')
            ->where('status_pendaftaran','terdaftar')
            ->get();
    }

    public function headings(): array
    {
        return ['No','Nama Peserta','Email','No. HP','Instansi','Jenis Kelamin','Status Pembayaran','Status Kehadiran','Tanda Tangan'];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no, $row->peserta->nama, $row->peserta->email, $row->peserta->no_hp,
            $row->peserta->instansi ?? '-',
            $row->peserta->kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            ucfirst(str_replace('_',' ',$row->pembayaran?->status_pembayaran ?? 'gratis')),
            ucfirst(str_replace('_',' ',$row->status_kehadiran ?? 'belum')),
            '', // kolom tanda tangan kosong untuk ditandatangani manual
        ];
    }

    public function columnWidths(): array
    {
        return ['A'=>5,'B'=>30,'C'=>32,'D'=>16,'E'=>26,'F'=>16,'G'=>20,'H'=>18,'I'=>24];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold'=>true,'color'=>['argb'=>'FFFFFFFF']],
                'fill' => ['fillType'=>Fill::FILL_SOLID,'startColor'=>['argb'=>'FF131218']],
                'alignment' => ['horizontal'=>Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
