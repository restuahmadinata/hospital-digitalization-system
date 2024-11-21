<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $fillable = [
        'nama_obat', 'deskripsi', 'tipe_obat', 'stok', 'gambar_obat', 'kedaluwarsa', 'status_kedaluwarsa',
    ];

    /**
     * Menentukan status kedaluwarsa obat
     */
    public function updateStatusKedaluwarsa()
    {
        if (Carbon::now()->gt(Carbon::parse($this->kedaluwarsa))) {
            $this->status_kedaluwarsa = 'kedaluwarsa';
        } else {
            $this->status_kedaluwarsa = 'belum kedaluwarsa';
        }
        $this->save();
    }

    /**
     * Relasi n-to-n dengan RekamMedis
     */
    public function rekamMedis()
    {
        return $this->belongsToMany(RekamMedis::class, 'rekam_medis_obat', 'obat_id', 'rekam_medis_id');
    }
}