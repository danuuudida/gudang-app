<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Search --}}
                    <form method="GET" action="{{ route('products.index') }}" class="mb-4 flex gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari nama / barcode..."
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                        >
                            Cari
                        </button>
                        <a
                            href="{{ route('products.create') }}"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                        >
                            + Tambah Produk
                        </a>
                    <div class="flex gap-3 mb-4">
                        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" required class="border p-2 rounded">
                            <button class="bg-green-600 text-white px-4 py-2 rounded">
                                Import Excel
                            </button>
                        </form>

                        <a href="{{ route('products.export') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                            Export Excel
                        </a>
                    </div>


                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-2 text-left">Barcode</th>
                                    <th class="px-4 py-2 text-left">Nama Barang</th>
                                    <th class="px-4 py-2 text-left">Kategori</th>
                                    <th class="px-4 py-2 text-left">Stok</th>
                                    <th class="px-4 py-2 text-left">Satuan</th>
                                    <th class="px-4 py-2 text-left">Harga Jual</th>
                                    <th class="px-4 py-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $product->barcode }}</td>
                                        <td class="px-4 py-2">{{ $product->nama_barang }}</td>
                                        <td class="px-4 py-2">{{ $product->category ? $product->category->nama_kategori : '-' }}</td>
                                        <td class="px-4 py-2">{{ $product->stok }}</td>
                                        <td class="px-4 py-2">{{ $product->satuan }}</td>
                                        <td class="px-4 py-2">
                                            {{ $product->harga_jual ? 'Rp ' . number_format($product->harga_jual, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-right space-x-2">
                                            <a
                                                href="{{ route('products.edit', $product) }}"
                                                class="text-indigo-600 hover:underline"
                                            >
                                                Edit
                                            </a>

                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="text-red-600 hover:underline"
                                                    onclick="return confirm('Yakin mau hapus?')"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                            Belum ada produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
