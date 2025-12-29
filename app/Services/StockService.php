<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockService
{
    /**
     * Process stock OUT (mengurangi stok)
     */
    public function processStockOut(string $barcode, int $qty, ?string $keterangan = null)
    {
        return DB::transaction(function () use ($barcode, $qty, $keterangan) {
            // 1. Lock dan ambil product
            $product = Product::where('barcode', trim($barcode))
                              ->lockForUpdate()
                              ->first();

            if (!$product) {
                throw new \Exception("Produk dengan barcode '{$barcode}' tidak ditemukan.");
            }

            // 2. Validasi stok
            if (!$product->hasEnoughStock($qty)) {
                throw new \Exception(
                    "Stok tidak mencukupi. Stok tersedia: {$product->stok}, diminta: {$qty}"
                );
            }

            // 3. Simpan stok sebelum
            $stokSebelum = $product->stok;

            // 4. Kurangi stok
            $product->stok -= $qty;
            $product->save();

            // 5. Catat movement
            $movement = StockMovement::create([
                'product_id' => $product->id,
                'type' => 'OUT',
                'qty' => $qty,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $product->stok,
                'keterangan' => $keterangan ?? 'Scan barang keluar',
                'user_id' => Auth::id(),
            ]);

            return [
                'product' => $product->fresh(),
                'movement' => $movement,
                'stok_sebelum' => $stokSebelum,
            ];
        });
    }

    /**
     * Process stock IN (menambah stok)
     */
    public function processStockIn(string $barcode, int $qty, ?string $keterangan = null)
    {
        return DB::transaction(function () use ($barcode, $qty, $keterangan) {
            // 1. Lock dan ambil product
            $product = Product::where('barcode', trim($barcode))
                              ->lockForUpdate()
                              ->first();

            if (!$product) {
                throw new \Exception("Produk dengan barcode '{$barcode}' tidak ditemukan.");
            }

            // 2. Simpan stok sebelum
            $stokSebelum = $product->stok;

            // 3. Tambah stok
            $product->stok += $qty;
            $product->save();

            // 4. Catat movement
            $movement = StockMovement::create([
                'product_id' => $product->id,
                'type' => 'IN',
                'qty' => $qty,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $product->stok,
                'keterangan' => $keterangan ?? 'Scan barang masuk',
                'user_id' => Auth::id(),
            ]);

            return [
                'product' => $product->fresh(),
                'movement' => $movement,
                'stok_sebelum' => $stokSebelum,
            ];
        });
    }
}