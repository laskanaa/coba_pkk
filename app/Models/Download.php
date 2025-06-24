<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'nama_file',
        'path',
        'count_view',
        'count_download'
    ];
}
