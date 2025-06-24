<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
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
