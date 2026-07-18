<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Informasi extends Model {
    use HasHashid;
    protected $table='informasi';
    protected $fillable=['admin_id','judul','isi','jenis'];
    public function admin() { return $this->belongsTo(Admin::class); }
    public function scopeInfo($q) { return $q->where('jenis','info'); }
    public function scopeFaq($q)  { return $q->where('jenis','faq'); }
}
