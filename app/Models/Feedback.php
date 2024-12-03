<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id',
        'pasien_id',
        'rating',
        'ulasan',
    ];

    /**
     * Relasi dengan Dokter (User)
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    /**
     * Relasi dengan Pasien (User)
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }
}