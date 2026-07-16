<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Sertifikat extends Model {
    use HasHashid;
    protected $table='sertifikat';
    protected $fillable=['pendaftaran_id','nomor_sertifikat','file_sertifikat','gambar_latar','tgl_terbit'];
    protected $casts=['tgl_terbit'=>'date'];
    public function pendaftaran() { return $this->belongsTo(Pendaftaran::class); }
    public static function generateNomor(int $kegiatanId, int $pendaftaranId): string {
        return sprintf('CERT/%s/%04d/%06d', now()->year, $kegiatanId, $pendaftaranId);
    }
}
