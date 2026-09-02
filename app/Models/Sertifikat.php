<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Sertifikat extends Model {
    use HasHashid;
    protected $table='sertifikat';
    protected $fillable=['pendaftaran_id','nomor_sertifikat','file_sertifikat','gambar_latar','ttd_snapshot','tgl_terbit'];
    protected $casts=['tgl_terbit'=>'date', 'ttd_snapshot'=>'array'];
    public function pendaftaran() { return $this->belongsTo(Pendaftaran::class); }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ttd_snapshot)) {
                $aktif = TandaTangan::getAktif();
                $model->ttd_snapshot = [
                    'dekan_nama'    => $aktif->dekan_nama,
                    'dekan_jabatan' => $aktif->dekan_jabatan,
                    'dekan_nip'     => $aktif->dekan_nip,
                    'dekan_ttd'     => $aktif->dekan_ttd,
                    'ketua_nama'    => $aktif->ketua_nama,
                    'ketua_jabatan' => $aktif->ketua_jabatan,
                    'ketua_nip'     => $aktif->ketua_nip,
                    'ketua_ttd'     => $aktif->ketua_ttd,
                ];
            }
        });
    }

    public static function generateNomor(int $kegiatanId, int $pendaftaranId): string {
        return sprintf('CERT/%s/%04d/%06d', now()->year, $kegiatanId, $pendaftaranId);
    }
}
