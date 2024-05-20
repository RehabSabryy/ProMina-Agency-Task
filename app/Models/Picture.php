<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'pic_name',
        'path',
        'album_id',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
