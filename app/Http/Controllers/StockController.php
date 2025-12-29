<?php

namespace App\Http\Controllers;

use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Tampilkan form scan barang keluar
     */
    public function scanOutForm()
    {
        return view('stock.scan-out');
    }

    /**
     * Process scan barang keluar
     */
    public function scanOutProcess(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            $result = $this->stockService->processStockOut(
                $request->barcode,
                $request->qty,
                $request->keterangan
            );

            return back()->with('success', [
                'message' => 'Barang berhasil dikeluarkan!',
                'product' => $result['product'],
                'stok_sebelum' => $result['stok_sebelum'],
                'qty' => $request->qty,
            ]);

        } catch (\Exception $e) {
            Log::error('Stock OUT Error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Tampilkan form scan barang masuk
     */
    public function scanInForm()
    {
        return view('stock.scan-in');
    }

    /**
     * Process scan barang masuk
     */
    public function scanInProcess(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            $result = $this->stockService->processStockIn(
                $request->barcode,
                $request->qty,
                $request->keterangan
            );

            return back()->with('success', [
                'message' => 'Barang berhasil ditambahkan!',
                'product' => $result['product'],
                'stok_sebelum' => $result['stok_sebelum'],
                'qty' => $request->qty,
            ]);

        } catch (\Exception $e) {
            Log::error('Stock IN Error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())
                        ->withInput();
        }
    }
}