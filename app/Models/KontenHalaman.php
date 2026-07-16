<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KontenHalaman extends Model {
    protected $table='konten_halaman';
    protected $fillable=['jenis','judul','isi','gambar'];
    public const LABEL=['beranda'=>'Beranda','tentang_kami'=>'Tentang Kami','visi_misi_tujuan'=>'Visi Misi & Tujuan','tata_cara_pendaftaran'=>'Tata Cara Pendaftaran'];
    public static function getByJenis(string $jenis): ?self { return self::where('jenis',$jenis)->first(); }
    public static function simpan(string $jenis, array $data): self { return self::updateOrCreate(['jenis'=>$jenis],$data); }
}
