<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TahunKegiatan extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'tahun_kegiatan';

    protected $fillable = [
        'id',
        'tahun',
        'nama',
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function tim_kegiatan(): HasMany
    {
        return $this->hasMany(TimKegiatan::class, 'id_tahun_kegiatan', 'id')->orderBy('updated_at','desc');
    }

    public function laporan_kegiatan(): HasMany
    {
        return $this->hasMany(LaporanKegiatan::class, 'id_tahun_kegiatan', 'id');
    }
}
