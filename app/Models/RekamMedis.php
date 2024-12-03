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
        'penyakit',
        'tindakan',
        'tanggal_berobat',
    ];

    protected $dates = [
        'tanggal_berobat',
    ];

    protected $casts = [
        'tanggal_berobat' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'rekam_medis_obat', 'rekam_medis_id', 'obat_id')
                    ->withPivot('jumlah');
    }
}