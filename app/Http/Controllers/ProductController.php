<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');

    $products = Product::with('category')
    ->when($search, function ($query) use ($search) {
        $query->search($search);
    })
    ->orderBy('nama_barang')
    ->paginate(20);

    return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();

        return view('products.form', compact('categories'));
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
            'category_id' => 'required|exists:categories,id',
        ]);
    
        try {
            Product::create($validated);
    
            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
    
            // logging untuk production
            Log::error('Gagal menambahkan produk', [
                'error' => $e->getMessage(),
                'data'  => $validated,
            ]);
    
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk.');
        }
    }

    public function edit(Product $product)
    {
         $categories = Category::orderBy('nama_kategori')->get();
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
        'category_id' => 'required|exists:categories,id',
    ]);

    try {
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    } catch (\Exception $e) {

        // logging untuk kebutuhan debugging di production
        Log::error('Gagal memperbarui produk', [
            'product_id' => $product->id,
            'error'      => $e->getMessage(),
            'data'       => $validated,
        ]);

        return back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat memperbarui produk.');
    }
}

    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil dihapus!');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls'
    ]);

    Excel::import(new ProductsImport, $request->file('file'));

    return back()->with('success', 'Import berhasil');
}

    public function export()
    {
        return Excel::download(new ProductsExport, 'data-produk.xlsx');
    }


}
