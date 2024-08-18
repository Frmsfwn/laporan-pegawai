<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AnggotaTim extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'anggota_tim';

    protected $fillable = [
        'id',
        'id_tim_kegiatan',
        'id_anggota',
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

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'id_anggota');
    }
}
