<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}">
                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif

                        <!-- Barcode -->
                        <div class="mb-4">
                            <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">
                                Barcode <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="barcode" 
                                id="barcode" 
                                value="{{ old('barcode', $product->barcode ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('barcode') border-red-500 @enderror"
                                required
                                autofocus
                            >
                            @error('barcode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Barcode harus unik untuk setiap produk</p>
                        </div>

                        <!-- Nama Barang -->
                        <div class="mb-4">
                            <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Barang <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama_barang" 
                                id="nama_barang" 
                                value="{{ old('nama_barang', $product->nama_barang ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama_barang') border-red-500 @enderror"
                                required
                            >
                            @error('nama_barang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Kategori (Master Data) -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>

                            <select
                                name="category_id"
                                id="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                    focus:border-indigo-500 focus:ring-indigo-500
                                    @error('category_id') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SKU (Optional) -->
                        <div class="mb-4">
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                SKU <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <input 
                                type="text" 
                                name="sku" 
                                id="sku" 
                                value="{{ old('sku', $product->sku ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Contoh: PRD-001"
                            >
                        </div>

                        <!-- Row: Stok & Satuan -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stok Awal <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    name="stok" 
                                    id="stok" 
                                    value="{{ old('stok', $product->stok ?? 0) }}"
                                    min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('stok') border-red-500 @enderror"
                                    required
                                >
                                @error('stok')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Satuan
                                </label>
                                <select 
                                    name="satuan" 
                                    id="satuan" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="pcs" {{ old('satuan', $product->satuan ?? 'pcs') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="box" {{ old('satuan', $product->satuan ?? '') == 'box' ? 'selected' : '' }}>Box</option>
                                    <option value="pack" {{ old('satuan', $product->satuan ?? '') == 'pack' ? 'selected' : '' }}>Pack</option>
                                    <option value="unit" {{ old('satuan', $product->satuan ?? '') == 'unit' ? 'selected' : '' }}>Unit</option>
                                    <option value="kg" {{ old('satuan', $product->satuan ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="liter" {{ old('satuan', $product->satuan ?? '') == 'liter' ? 'selected' : '' }}>Liter</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row: Harga Beli & Harga Jual -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Beli <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                    <input 
                                        type="number" 
                                        name="harga_beli" 
                                        id="harga_beli" 
                                        value="{{ old('harga_beli', $product->harga_beli ?? '') }}"
                                        min="0"
                                        step="0.01"
                                        class="mt-1 block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="0"
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Jual <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                    <input 
                                        type="number" 
                                        name="harga_jual" 
                                        id="harga_jual" 
                                        value="{{ old('harga_jual', $product->harga_jual ?? '') }}"
                                        min="0"
                                        step="0.01"
                                        class="mt-1 block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="0"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-800">
                                ← Kembali
                            </a>
                            <button 
                                type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline"
                            >
                                {{ isset($product) ? 'Update Produk' : 'Simpan Produk' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>