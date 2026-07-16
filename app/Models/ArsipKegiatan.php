<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class ArsipKegiatan extends Model {
    use HasHashid;
    protected $table='arsip_kegiatan';
    protected $fillable=['kegiatan_id','judul','ringkasan','berita_acara','dokumentasi'];
    protected $casts=['dokumentasi'=>'array'];
    public function kegiatan() { return $this->belongsTo(Kegiatan::class); }
    public function tambahDokumentasi(string $path): void {
        $docs=$this->dokumentasi??[]; $docs[]=$path; $this->update(['dokumentasi'=>$docs]);
    }
}
