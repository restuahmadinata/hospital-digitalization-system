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
        'konfirmasi',
        'tanggal_konsultasi'
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }
}