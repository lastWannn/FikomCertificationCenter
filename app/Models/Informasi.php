<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
use Illuminate\Support\Carbon;
class Informasi extends Model {
    use HasHashid;
    protected $table='informasi';
    protected $fillable=['admin_id','judul','isi','jenis','tayang_mulai','tayang_selesai'];
    protected $casts=['tayang_mulai'=>'datetime','tayang_selesai'=>'datetime'];
    public function admin() { return $this->belongsTo(Admin::class); }
    public function scopeInfo($q) { return $q->where('jenis','info'); }
    public function scopeFaq($q)  { return $q->where('jenis','faq'); }
    /** Scope: aktif = belum kedaluwarsa (tayang_selesai null atau >= now) dan sudah mulai (tayang_mulai null atau <= now) */
    public function scopeAktif($q) {
        $now = Carbon::now();
        return $q->where(function($q) use ($now) {
            $q->whereNull('tayang_mulai')->orWhere('tayang_mulai','<=',$now);
        })->where(function($q) use ($now) {
            $q->whereNull('tayang_selesai')->orWhere('tayang_selesai','>=',$now);
        });
    }
}
