<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TandaTangan extends Model
{
    protected $table = 'tanda_tangan';

    protected $fillable = [
        'dekan_nama',
        'dekan_jabatan',
        'dekan_nip',
        'dekan_ttd',
        'ketua_nama',
        'ketua_jabatan',
        'ketua_nip',
        'ketua_ttd',
        'bendahara_nama',
        'bendahara_jabatan',
        'bendahara_nip',
        'bendahara_ttd',
        'proktor_nama',
        'proktor_jabatan',
        'proktor_nip',
        'proktor_ttd',
    ];

    /**
     * Ambil / buat record tanda tangan aktif tunggal (singleton)
     */
    public static function getAktif(): self
    {
        $payload = [
            'dekan_nama'        => 'Purnawansyah',
            'dekan_jabatan'     => 'DEKAN',
            'ketua_nama'        => "Abdul Rachman Manga'",
            'ketua_jabatan'     => 'KETUA UNIT',
            'bendahara_nama'    => 'Panitia FCC',
            'bendahara_jabatan' => 'BENDAHARA / KEUANGAN',
        ];

        if (Schema::hasTable('tanda_tangan') && Schema::hasColumn('tanda_tangan', 'proktor_nama')) {
            $payload['proktor_nama']    = "Ir. Abdul Rachman Manga', S.Kom., M.T., MTA., MCF";
            $payload['proktor_jabatan'] = 'PROKTOR UJIAN';
        }

        $aktif = self::firstOrCreate([], $payload);

        if (Schema::hasTable('tanda_tangan') && Schema::hasColumn('tanda_tangan', 'proktor_nama') && empty($aktif->proktor_nama)) {
            $aktif->update([
                'proktor_nama'    => "Ir. Abdul Rachman Manga', S.Kom., M.T., MTA., MCF",
                'proktor_jabatan' => 'PROKTOR UJIAN',
            ]);
        }

        return $aktif;
    }

    public function getDekanTtdUrlAttribute(): ?string
    {
        return $this->dekan_ttd ? asset('storage/' . $this->dekan_ttd) : null;
    }

    public function getKetuaTtdUrlAttribute(): ?string
    {
        return $this->ketua_ttd ? asset('storage/' . $this->ketua_ttd) : null;
    }

    public function getBendaharaTtdUrlAttribute(): ?string
    {
        return $this->bendahara_ttd ? asset('storage/' . $this->bendahara_ttd) : null;
    }

    public function getProktorTtdUrlAttribute(): ?string
    {
        return $this->proktor_ttd ? asset('storage/' . $this->proktor_ttd) : null;
    }
}
