<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'dokter_id',
        'jenis_dokter',
        'spesialisasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}