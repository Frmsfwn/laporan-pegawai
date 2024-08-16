<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TimKegiatan extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'tim_kegiatan';

    protected $fillable = [
        'id',
        'nama',
        'id_tahun_kegiatan',
        'id_ketua',
        'id_anggota',
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function tahun_kegiatan(): BelongsTo
    {
        return $this->belongsTo(TahunKegiatan::class, 'id_tahun_kegiatan', 'id');
    }

    public function anggota_tim(): HasMany
    {
        return $this->hasMany(AnggotaTim::class, 'id_tim_kegiatan', 'id');
    }

    public function laporan_kegiatan(): HasMany
    {
        return $this->hasMany(LaporanKegiatan::class, 'id_tim_kegiatan', 'id');
    }
}
