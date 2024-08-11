<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'nip',
        'nama',
        'role',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function anggota_tim(): BelongsTo
    {
        return $this->belongsTo(AnggotaTim::class, 'id', 'id_anggota');
    }

    public function laporan_kegiatan(): BelongsTo
    {
        return $this->belongsTo(LaporanKegiatan::class, 'id', 'id_anggota');
    }
}
