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
            'kategori_id' => 'required|exists:kategoris,id'  // Validasi kategori_id
        ]);

        $buku = Buku::create($validated);  // Menyimpan data yang tervalidasi
        return response()->json($buku, 201);  // Mengembalikan data buku yang dibuat
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

        $buku = Buku::findOrFail($id);  // Mencari buku berdasarkan ID
        $buku->update($validated);  // Memperbarui data buku
        return response()->json($buku, 200);  // Mengembalikan data buku yang telah diperbarui
    }

    // Pencarian buku berdasarkan nama buku atau kategori
    public function cari(Request $request)
    {
        $query = $request->input('query');

        // Pencarian berdasarkan nama buku atau nama kategori
        $bukus = Buku::where('nama', 'like', "%$query%")
                     ->orWhereHas('kategori', function ($q) use ($query) {
                         $q->where('nama_kategori', 'like', "%$query%");  // Pastikan kolom kategori yang digunakan benar
                     })
                     ->get();

        return response()->json($bukus);
    }

    // Menampilkan semua buku
    public function index()
    {
        $bukus = Buku::all();  // Mengambil semua data buku dari database
        return response()->json($bukus);  // Mengembalikan data buku dalam bentuk JSON
    }

    // Menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => "Buku dengan ID $id tidak ditemukan"
            ], 404);  // Mengembalikan error jika buku tidak ditemukan
        }

        return response()->json($buku);  // Mengembalikan data buku
    }

    // Pencarian buku berdasarkan nama atau kategori_id
    public function search(Request $request)
{
    // Membuat query untuk mencari buku
    $query = Buku::query();

    // Cari berdasarkan judul buku (gunakan kolom 'judul' yang benar)
    if ($request->has('judul')) {
        $query->where('judul', 'like', '%' . $request->input('judul') . '%');  // Mengganti 'nama' dengan 'judul'
    }

    // Cari berdasarkan kategori_id jika ada parameter 'kategori_id'
    if ($request->has('kategori_id')) {
        $query->where('kategori_id', $request->input('kategori_id'));
    }

    // Jalankan query dan ambil hasil pencarian
    $bukus = $query->get();

    // Jika tidak ada hasil, kembalikan pesan error
    if ($bukus->isEmpty()) {
        return response()->json([
            'message' => 'Tidak ada buku yang ditemukan dengan kriteria pencarian.',
        ], 404);
    }

    // Kembalikan data buku yang ditemukan
    return response()->json($bukus, 200);
}


}
