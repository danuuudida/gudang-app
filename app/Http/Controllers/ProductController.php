<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');

    $products = Product::when($search, function ($query) use ($search) {
            $query->search($search);
        })
        ->orderBy('nama_barang')
        ->paginate(20);

    return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('products.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barcode' => 'required|string|unique:products,barcode',
            'nama_barang' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'barcode' => 'required|string|unique:products,barcode,' . $product->id,
            'nama_barang' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil dihapus!');
    }
}