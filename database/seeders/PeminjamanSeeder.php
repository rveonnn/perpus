<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('peminjaman')->insert([
            'user_id' => 1,
            'buku_id' => 1,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays(7),
        ]);

        // Pinjam 10 hari lalu, kembali hari ini (terlambat)
        DB::table('peminjaman')->insert([
            'user_id' => 2,
            'buku_id' => 2,
            'tanggal_pinjam' => Carbon::now()->subDays(10),
            'tanggal_kembali' => Carbon::now(),
        ]);

        // Pinjam hari ini, kembali dalam 5 hari (masih valid)
        DB::table('peminjaman')->insert([
            'user_id' => 3,
            'buku_id' => 3,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays(5),
        ]);
    }
}

