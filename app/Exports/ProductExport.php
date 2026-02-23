<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select(
            'barcode',
            'nama_barang',
            'sku',
            'stok',
            'satuan',
            'harga_beli',
            'harga_jual'
        )->get();
    }

    public function headings(): array
    {
        return [
            'barcode',
            'nama_barang',
            'sku',
            'stok',
            'satuan',
            'harga_beli',
            'harga_jual',
        ];
    }
}
