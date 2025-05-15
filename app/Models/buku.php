<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;
    protected $table ='buku';

    protected $fillable = [
        'judul',
        'sinopsis',
        'penulis',
        'penerbit',
        'tahun',
        'foto',
        'status'
    ];
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
