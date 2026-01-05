<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pergerakan Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Top Actions --}}
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="space-y-1">
                    <h3 class="text-lg font-semibold text-gray-800">History Stok</h3>
                    <p class="text-sm text-gray-500">
                        Log semua pergerakan stok barang (masuk & keluar).
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('stock.scan-in') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700">
                        Barang Masuk
                    </a>
                    <a href="{{ route('stock.scan-out') }}"
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700">
                        Barang Keluar
                    </a>
                    @auth
                    @if(auth()->user()->role === 'superadmin')
                        <a href="{{ route('stock.history.export', request()->query()) }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700">
                            Export Excel
                        </a>
                    @endif
                    @endauth
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <form method="GET" action="{{ route('stock.history') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        {{-- Produk --}}
                        <div>
                            <label for="product_id" class="block text-xs font-semibold text-gray-600 mb-1">
                                Produk
                            </label>
                            <select name="product_id" id="product_id"
                                    class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->nama_barang }} ({{ $product->barcode }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tipe --}}
                        <div>
                            <label for="type" class="block text-xs font-semibold text-gray-600 mb-1">
                                Tipe Pergerakan
                            </label>
                            <select name="type" id="type"
                                    class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                <option value="IN" {{ request('type') === 'IN' ? 'selected' : '' }}>Masuk</option>
                                <option value="OUT" {{ request('type') === 'OUT' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>

                        {{-- Dari Tanggal --}}
                        <div>
                            <label for="date_from" class="block text-xs font-semibold text-gray-600 mb-1">
                                Dari Tanggal
                            </label>
                            <input type="date" name="date_from" id="date_from"
                                   value="{{ request('date_from') }}"
                                   class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Sampai Tanggal + Buttons --}}
                        <div>
                            <label for="date_to" class="block text-xs font-semibold text-gray-600 mb-1">
                                Sampai Tanggal
                            </label>
                            <div class="flex gap-2">
                                <input type="date" name="date_to" id="date_to"
                                       value="{{ request('date_to') }}"
                                       class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700">
                                    Filter
                                </button>
                            </div>
                            @if(request()->hasAny(['product_id','type','date_from','date_to']))
                                <a href="{{ route('stock.history') }}"
                                   class="inline-block mt-2 text-xs text-gray-500 hover:text-gray-700">
                                    Reset filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                                    <th class="px-3 py-2 text-left">Tanggal</th>
                                    <th class="px-3 py-2 text-left">Produk</th>
                                    <th class="px-3 py-2 text-left">Barcode</th>
                                    <th class="px-3 py-2 text-center">Tipe</th>
                                    <th class="px-3 py-2 text-right">Qty</th>
                                    <th class="px-3 py-2 text-left">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($movements as $movement)
                                    <tr class="hover:bg-gray-50">
                                        {{-- Tanggal --}}
                                        <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-600">
                                            {{ $movement->created_at?->format('d-m-Y H:i') }}
                                        </td>

                                        {{-- Nama Produk --}}
                                        <td class="px-3 py-2">
                                            <div class="font-semibold text-gray-800">
                                                {{ optional($movement->product)->nama_barang ?? '-' }}
                                            </div>
                                            @if(optional($movement->product)->satuan)
                                                <div class="text-xs text-gray-500">
                                                    Satuan: {{ $movement->product->satuan }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Barcode --}}
                                        <td class="px-3 py-2 font-mono text-xs text-gray-700">
                                            {{ optional($movement->product)->barcode ?? '-' }}
                                        </td>

                                        {{-- Tipe --}}
                                        <td class="px-3 py-2 text-center">
                                            @if($movement->type === 'IN')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                    Masuk
                                                </span>
                                            @elseif($movement->type === 'OUT')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                    Keluar
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                                    {{ $movement->type }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Qty --}}
                                        <td class="px-3 py-2 text-right font-semibold">
                                            @if($movement->type === 'OUT')
                                                <span class="text-red-600">-{{ $movement->qty }}</span>
                                            @else
                                                <span class="text-green-600">+{{ $movement->qty }}</span>
                                            @endif
                                        </td>

                                        {{-- Keterangan --}}
                                        <td class="px-3 py-2 text-xs text-gray-700 max-w-xs">
                                            {{ $movement->keterangan ?: '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 py-6 text-center text-sm text-gray-500">
                                            Belum ada data pergerakan stok.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $movements->withQueryString()->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
