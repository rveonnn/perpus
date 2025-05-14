<?php

namespace App\Http\Controllers\Api;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Pinjam buku (anggota)
    public function pinjam(Request $request, Buku $buku)
    {
        // pengecekan status buku
        if ($buku->status !== 'available') {
            return response()->json(['message' => 'Buku sedang tidak tersedia.'], 400);
        }

        $tanggalPeminjaman = now();
        $tanggalPengembalian = $tanggalPeminjaman->copy()->addDays(7);

        if ($tanggalPengembalian <= $tanggalPeminjaman) {
        return response()->json([
            'message' => 'Tanggal pengembalian harus setelah tanggal peminjaman.'
        ], 400);
    }

        // Buat data peminjaman
        Peminjaman::create([
            'user_id' => $request->user()->id,
            'buku_id' => $buku->id,
            'tanggal_peminjaman' => $tanggalPeminjaman,
            'tanggal_pengembalian' => $tanggalPengembalian,
            'tanggal_dikembalikan' => null,
            'status' => 'belum dikembalikan', // default saat pinjam
        ]);

        // Update status buku jadi "unavailable"
        $buku->update(['status' => 'unavailable']);

        return response()->json(['message' => 'Buku berhasil dipinjam.']);
    }

    // Kembalikan buku (anggota)
    public function kembalikan(Request $request, Buku $buku)
    {
        $peminjaman = Peminjaman::where('user_id', $request->user()->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'belum dikembalikan') // Pastikan status masih default
            ->first();

        if (!$peminjaman) {
            return response()->json(['message' => 'Tidak ada peminjaman aktif untuk buku ini.'], 404);
        }

            if ($peminjaman->tanggal_pengembalian <= $peminjaman->tanggal_peminjaman) {
        return response()->json([
            'message' => 'Data peminjaman tidak valid: tanggal pengembalian ≤ tanggal peminjaman.',
            'debug' => [
                'tanggal_peminjaman' => $peminjaman->tanggal_peminjaman,
                'tanggal_pengembalian' => $peminjaman->tanggal_pengembalian
            ]
        ], 400);
    }

        $tanggalPengembalian = Carbon::parse($peminjaman->tanggal_pengembalian);
        $sekarang = now();

        // Perbaikan utama: Gunakan diff dengan parameter false untuk mendapatkan nilai negatif
        $selisihHari = $sekarang->diffInDays($tanggalPengembalian, false);

        if ($selisihHari < 0) {
            $status = 'telat';
            $hariTerlambat = abs($selisihHari); // Konversi ke positif
        } else {
            $status = 'tepat waktu';
            $hariTerlambat = 0;
        }

        $peminjaman->update([
            'tanggal_dikembalikan' => $sekarang,
            'status' => $status
        ]);

        $buku->update(['status' => 'available']);

        return response()->json([
            'message' => 'Buku berhasil dikembalikan.',
            'late' => $status === 'telat',
            'days_late' => $hariTerlambat,
            'status' => $status
        ]);
    }
    public function peminjamanUser(Request $request)
    {
        $user = $request->user();
        $peminjaman = Peminjaman::where('user_id', Auth::user()->id)->with('buku')->get();

        if ($peminjaman->isEmpty()) {
            return response()->json(['message' => 'Tidak ada buku yang dipinjam']);
        }

        return response()->json($peminjaman);
    }
}
