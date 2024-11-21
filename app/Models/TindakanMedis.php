<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakanMedis extends Model
{
    use HasFactory;

    protected $fillable = ['pasien_id', 'dokter_id', 'deskripsi', 'tanggal', 'notifikasi'];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}