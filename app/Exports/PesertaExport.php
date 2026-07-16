<?php
namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\{Fill, Font, Alignment, Border};

class PesertaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    public function title(): string { return 'Daftar Peserta'; }

    public function collection()
    {
        return Peserta::withCount('pendaftaran')->orderBy('nama')->get();
    }

    public function headings(): array
    {
        return ['No','Nama Lengkap','Email','No. HP','Jenis Kelamin','Instansi/Asal','Status Akun','Total Kegiatan','Tanggal Daftar'];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no, $row->nama, $row->email, $row->no_hp,
            $row->kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            $row->instansi ?? '-', ucfirst($row->status_akun ?? 'aktif'),
            $row->pendaftaran_count, $row->created_at->format('d/m/Y'),
        ];
    }

    public function columnWidths(): array
    {
        return ['A'=>6,'B'=>30,'C'=>32,'D'=>18,'E'=>16,'F'=>28,'G'=>16,'H'=>16,'I'=>18];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold'=>true,'color'=>['argb'=>'FF131218']],
                'fill'      => ['fillType'=>Fill::FILL_SOLID,'startColor'=>['argb'=>'FFFFC81A']],
                'alignment' => ['horizontal'=>Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
