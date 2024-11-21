<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'obat_id',
        'tindakan',
        'tanggal_berobat',
    ];

    /**
     * Relasi dengan model Pasien (users yang memiliki peran Pasien)
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    /**
     * Relasi dengan model Dokter (users yang memiliki peran Dokter)
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    /**
     * Relasi dengan model Obat
     */
    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'rekam_medis_obat', 'rekam_medis_id', 'obat_id');
    }
}