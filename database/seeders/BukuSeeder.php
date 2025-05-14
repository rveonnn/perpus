<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Buku::insert([
            [
                'judul' => 'Laskar Pelangi',
                'sinopsis' => 'Kisah persahabatan anak-anak di Belitung',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun' => "2005",
                'foto' => 'https://upload.wikimedia.org/wikipedia/id/thumb/1/17/Laskar_Pelangi_film.jpg/375px-Laskar_Pelangi_film.jpg',
                'status' => 'available'
            ],
            [
                'judul' => 'Filosofi Teras',
                'sinopsis' => 'Pengenalan filsafat Stoicism dan penerapannya dalam kehidupan modern',
                'penulis' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun' => "2018",
                'foto' => 'https://0.academia-photos.com/attachment_thumbnails/90694922/mini_magick20220905-1-at96yu.png?1662391280',
                'status' => 'available'
            ],
            [
                'judul' => 'Dilan: Dia Adalah Dilanku Tahun 1990',
                'sinopsis' => 'Kisah cinta masa SMA antara Milea dan Dilan di Bandung tahun 1990-an',
                'penulis' => 'Pidi Baiq',
                'penerbit' => 'Pastel Books',
                'tahun' => "2014",
                'foto' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1442310576i/22037542.jpg',
                'status' => 'available'
            ],
            [
                'judul' => 'The Midnight Library',
                'sinopsis' => 'Nora Seed menemukan perpustakaan ajaib yang memungkinkannya mencoba berbagai versi hidupnya',
                'penulis' => 'Matt Haig',
                'penerbit' => 'Canongate Books',
                'tahun' => "2020",
                'foto' => 'https://images-cdn.ubuy.co.id/6692276f8577e567a83a7af5-the-midnight-library-a-gma-book-club.jpg',
                'status' => 'available'
            ],
            [
                'judul' => 'Bumi',
                'sinopsis' => 'Petualangan Raib dan teman-temannya ke dunia paralel.',
                'penulis' => 'Tere Liye',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun' => "2014",
                'foto' => 'https://cdn.gramedia.com/uploads/items/9786020332956_Bumi-New-Cover.jpg',
                'status' => 'available'
            ],
            [
                'judul' => 'Supernova: Ksatria, Puteri dan Bintang Jatuh',
                'sinopsis' => 'Perjalanan spiritual dan ilmiah yang menyatukan dua dunia.',
                'penulis' => 'Dee Lestari',
                'penerbit' => 'Truedee Books',
                'tahun' => "2001",
                'foto' => 'https://upload.wikimedia.org/wikipedia/id/1/19/Poster_Film_Supernova-_Ksatria%2C_Putih%2C_%26_Bintang_Jatuh.jpeg',
                'status' => 'available'
            ],
            [
                'judul' => '9 Summers 10 Autumns',
                'sinopsis' => 'Perjalanan hidup dari Batu ke New York, menginspirasi dan menyentuh.',
                'penulis' => 'Iwan Setyawan',
                'penerbit' => 'Bentang Pustaka',
                'tahun' => "2011",
                'foto' => 'https://www.jagatreview.com/wp-content/uploads/2011/05/9-summers-19-autumns.jpg',
                'status' => 'available'
            ]
        ]);
    }
}
