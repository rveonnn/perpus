<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::paginate(8);

        return response()->json($buku);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sinopsis' => 'nullable|string',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun' => 'required|integer|min:1000|max:9999',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'status' => 'required|in:available,unavailable',
        ]);
        $buku = Buku::create($validated);
        return response()->json($buku, 201);

    }

    public function show($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $buku
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());
        return response()->json($buku);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return response()->json(['message' => 'Buku dihapus']);
    }


    public function search($keyword)
    {
        $buku = Buku::where('judul', 'like', "%{$keyword}%")
                    ->orWhere('sinopsis', 'like', "%{$keyword}%")
                    ->orWhere('penulis', 'like', "%{$keyword}%")
                    ->orWhere('penerbit', 'like', "%{$keyword}%")
                    ->paginate(10);

                    if ($buku->isEmpty()) {
                        return response()->json(['message' => 'Buku tidak ditemukan'], 404);
                    }
                    return response()->json($buku);
    }
}
