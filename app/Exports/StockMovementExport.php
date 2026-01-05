<?php

namespace App\Exports;

use App\Models\StockMovement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockMovementExport implements FromCollection, WithHeadings
{
    protected $filters;

    // nangkep filter dari request
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    // data apa yg masuk ke Excel
    public function collection()
    {
        $query = StockMovement::with('product');

        // filter produk
        if (!empty($this->filters['product_id'])) {
            $query->where('product_id', $this->filters['product_id']);
        }

        // filter tipe IN / OUT
        if (!empty($this->filters['type'])) {
            $query->where('type', $this->filters['type']);
        }

        // filter tanggal dari
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        // filter tanggal sampai
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        // mapping biar rapi di Excel
        return $query->get()->map(function ($m) {
            return [
                'Tanggal'    => $m->created_at->format('d-m-Y H:i'),
                'Produk'     => $m->product->nama_barang ?? '-',
                'Barcode'    => $m->product->barcode ?? '-',
                'Tipe'       => $m->type,
                'Qty'        => $m->qty,
                'Keterangan' => $m->keterangan,
            ];
        });
    }

    // header Excel
    public function headings(): array
    {
        return [
            'Tanggal',
            'Produk',
            'Barcode',
            'Tipe',
            'Qty',
            'Keterangan',
        ];
    }
}
