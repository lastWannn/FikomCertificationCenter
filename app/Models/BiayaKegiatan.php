<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class BiayaKegiatan extends Model {
    use HasHashid;
    protected $table='biaya_kegiatan';
    protected $fillable=['kegiatan_id','nama_jenis','nominal'];
    protected $casts=['nominal'=>'decimal:0'];
    public function kegiatan()    { return $this->belongsTo(Kegiatan::class); }
    public function pendaftaran() { return $this->hasMany(Pendaftaran::class); }
    public function getNominalFormatAttribute(): string { return 'Rp '.number_format($this->nominal,0,',','.'); }
}
