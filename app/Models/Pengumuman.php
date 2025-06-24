<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = [
        'judul',
        'image',
        'tag',
        'tanggal',
        'isi',
        'status'
    ];
    protected $casts = [
        'tanggal' => 'date',
    ];
}
