<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjadwalanKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'penjadwalan_konsultasi';

    protected $fillable = [
        'id_pasien',
        'id_dokter',
        'tanggal_konsultasi',
        'konfirmasi',
    ];

    /**
     * Relasi dengan model Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    /**
     * Relasi dengan model Dokter
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function isDokter()
    {
        return $this->dokter()->exists();
    }

    public function isPasien()
    {
        return $this->pasien()->exists();
    }
}