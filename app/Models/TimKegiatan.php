<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
