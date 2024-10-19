<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Menyimpan data buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:1000',
            'penulis' => 'required|string',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);

        $buku = Buku::create($validated);
        return response()->json($buku, 201);
    }

    // Memperbarui data buku
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:1000',
            'penulis' => 'required|string',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($validated);
        return response()->json($buku, 200);
    }
    public function cari(Request $request)
{
    $query = $request->input('query');

    // Pencarian berdasarkan nama buku atau nama kategori
    $bukus = Buku::where('nama', 'like', "%$query%")
                 ->orWhereHas('kategori', function ($q) use ($query) {
                     $q->where('nama', 'like', "%$query%");
                 })
                 ->get();

    return response()->json($bukus);
}

public function index()
{
    $bukus = Buku::all(); // Mengambil semua data buku dari database
    return response()->json($bukus); // Mengembalikan data buku dalam bentuk JSON
}

public function show($id)
{
    $buku = Buku::find($id);

    if (!$buku) {
        return response()->json([
            'message' => "Buku dengan ID $id tidak ditemukan"
        ], 404);
    }

    return response()->json($buku);
}
    


}
