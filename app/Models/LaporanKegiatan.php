<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class LaporanKegiatan extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'laporan_kegiatan';

    protected $fillable = [
        'id',
        'id_tim_kegiatan',
        'id_tahun_kegiatan',
        'status_laporan',
        'judul_laporan',
        'nama_tim_kegiatan',
        'informasi_kegiatan',
        'lampiran',
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function tim_kegiatan(): BelongsTo
    {
        return $this->belongsTo(TimKegiatan::class, 'id_tim_kegiatan', 'id');
    }

    public function tahun_kegiatan(): BelongsTo
    {
        return $this->belongsTo(TahunKegiatan::class, 'id_tahun_kegiatan', 'id');
    }
}
