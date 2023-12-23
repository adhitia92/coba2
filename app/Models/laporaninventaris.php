<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporaninventaris extends Model
{
    use HasFactory;

    protected $table = 'laporaninventaris';
    protected $primaryKey = 'idlaporaninventaris';
    protected $fillable = [
        'idkategori',
        'id',
        'idbarang',
        'kodebarcode', // Pastikan ada di kolom fillable jika diisi melalui formulir
        'namateknisi',
        'asalteknisi',
        'detail',
        'kondisiterbaru',
        'created_at',
        'gambarterbaru',
        // Tambahkan atribut lain sesuai kebutuhan
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang', 'idbarang');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
    }

    // Relasi dengan model User (misalnya, jika User adalah model default Laravel)
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
