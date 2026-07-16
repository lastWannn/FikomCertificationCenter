<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kontak extends Model {
    protected $table='kontak';
    protected $fillable=['alamat','telepon','email','maps_embed'];
    public static function aktif(): ?self { return self::latest()->first(); }
}
