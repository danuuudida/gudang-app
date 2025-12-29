<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'nama_barang',
        'sku',
        'stok',
        'satuan',
        'harga_beli',
        'harga_jual',
    ];

    protected $casts = [
        'stok' => 'integer',
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
    ];

    // Relasi ke stock movements
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('barcode', 'like', "%{$search}%")
              ->orWhere('nama_barang', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%");
        });
    }

    // Method helper untuk cek stok
    public function hasEnoughStock($qty)
    {
        return $this->stok >= $qty;
    }
}