<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
use Illuminate\Support\Facades\DB;
class Rekening extends Model {
    use HasHashid;
    protected $table='rekening';
    protected $fillable=['nama_pemilik','bank','no_rekening','is_active'];
    protected $casts=['is_active'=>'boolean'];
    public static function aktif(): ?self { return self::where('is_active',true)->first(); }
    public static function nonaktifkanSemua(): void { self::query()->update(['is_active'=>false]); }
    public function aktifkan(): void { DB::transaction(function(){ self::nonaktifkanSemua(); $this->update(['is_active'=>true]); }); }
}
