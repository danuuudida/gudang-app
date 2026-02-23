<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'barcode'     => $row['barcode'],
            'nama_barang' => $row['nama_barang'],
            'sku'         => $row['sku'] ?? null,
            'stok'        => $row['stok'],
            'satuan'      => $row['satuan'] ?? 'pcs',
            'harga_beli'  => $row['harga_beli'] ?? null,
            'harga_jual'  => $row['harga_jual'] ?? null,
        ]);
    }
}
