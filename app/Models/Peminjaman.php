<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
        use HasFactory;

        protected $table = 'peminjaman';
        protected $fillable = [
            'user_id',
            'buku_id',
            'tanggal_peminjaman',
            'tanggal_pengembalian',
            'tanggal_dikembalikan',
            'status'
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function buku()
        {
            return $this->belongsTo(Buku::class);
        }


    }

