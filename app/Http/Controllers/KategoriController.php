<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Kategori::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input, pastikan kolom 'nama_kategori' ada di database
            $request->validate(['nama_kategori' => 'required|unique:kategoris']);

            // Simpan kategori baru
            $kategori = Kategori::create($request->all());

            // Kembalikan response sukses
            return response()->json($kategori, 201);

        } catch (\Exception $e) {
            // Tangani error dan kembalikan response gagal
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::find($id);
        
        if ($kategori) {
            return response()->json($kategori);
        } else {
            return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cari kategori berdasarkan ID
            $kategori = Kategori::findOrFail($id);

            // Validasi input
            $request->validate(['nama_kategori' => 'required|unique:kategoris,nama_kategori,' . $id]);

            // Update data kategori
            $kategori->update($request->all());

            // Kembalikan response sukses
            return response()->json($kategori, 200);

        } catch (\Exception $e) {
            // Tangani error dan kembalikan response gagal
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cari kategori berdasarkan ID
            $kategori = Kategori::findOrFail($id);

            // Hapus kategori
            $kategori->delete();

            // Kembalikan response sukses
            return response()->json(['message' => 'Kategori berhasil dihapus'], 200);

        } catch (\Exception $e) {
            // Tangani error dan kembalikan response gagal
            return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
        }
    }
}
