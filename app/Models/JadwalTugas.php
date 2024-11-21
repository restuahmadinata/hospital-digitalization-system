<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTugas extends Model
{
    use HasFactory;

    protected $fillable = ['dokter_id', 'hari_tugas'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}