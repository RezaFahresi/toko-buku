<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Perbaikan pada Illuminate
use Illuminate\Database\Eloquent\Factories\HasFactory; // Perbaikan pada Illuminate

class kategori extends Model // Nama model sebaiknya diawali huruf kapital
{
    use HasFactory;

    /**
     * Kolom-kolom yang bisa diisi secara massal.
     */
    protected $fillable = ['nama_kategori'];

    /**
     * Relasi ke model Buku (kategori memiliki banyak buku).
     */
    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
