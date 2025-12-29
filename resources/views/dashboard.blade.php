<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Gudang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Message -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-600 mt-1">Kelola stok gudang Anda dengan mudah dan efisien</p>
            </div>

            <!-- Quick Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                <!-- Scan Barang Keluar -->
                <a href="{{ route('stock.scan-out') }}" class="block group">
                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm font-semibold uppercase tracking-wide">Scan Barang</p>
                                <h3 class="text-2xl font-bold mt-1">Keluar</h3>
                                <p class="text-red-100 text-xs mt-2">Kurangi stok</p>
                            </div>
                            <svg class="w-12 h-12 opacity-80 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Scan Barang Masuk -->
                <a href="{{ route('stock.scan-in') }}" class="block group">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-semibold uppercase tracking-wide">Scan Barang</p>
                                <h3 class="text-2xl font-bold mt-1">Masuk</h3>
                                <p class="text-green-100 text-xs mt-2">Tambah stok</p>
                            </div>
                            <svg class="w-12 h-12 opacity-80 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Kelola Produk -->
                <a href="{{ route('products.index') }}" class="block group">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-semibold uppercase tracking-wide">Kelola</p>
                                <h3 class="text-2xl font-bold mt-1">Produk</h3>
                                <p class="text-blue-100 text-xs mt-2">Master data</p>
                            </div>
                            <svg class="w-12 h-12 opacity-80 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Riwayat Stok -->
                <a href="{{ route('stock.history') }}" class="block group">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide">Lihat</p>
                                <h3 class="text-2xl font-bold mt-1">Riwayat</h3>
                                <p class="text-purple-100 text-xs mt-2">Stock movement</p>
                            </div>
                            <svg class="w-12 h-12 opacity-80 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @php
                    $totalStok = \App\Models\Product::sum('stok');
                    $totalProduk = \App\Models\Product::count();
                    $stokKeluarHariIni = \App\Models\StockMovement::where('type', 'OUT')
                                            ->whereDate('created_at', today())
                                            ->sum('qty');
                    $stokMasukHariIni = \App\Models\StockMovement::where('type', 'IN')
                                            ->whereDate('created_at', today())
                                            ->sum('qty');
                @endphp

                <!-- Total Stok -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Stok</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalStok) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Produk -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalProduk) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stok Masuk Hari Ini -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Masuk Hari Ini</p>
                            <p class="text-2xl font-bold text-green-600">+{{ number_format($stokMasukHariIni) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stok Keluar Hari Ini -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Keluar Hari Ini</p>
                            <p class="text-2xl font-bold text-red-600">-{{ number_format($stokKeluarHariIni) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities & Low Stock Alert -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Aktivitas Terbaru -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">📋 Aktivitas Terbaru</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $recentMovements = \App\Models\StockMovement::with(['product', 'user'])
                                                ->orderBy('created_at', 'desc')
                                                ->limit(5)
                                                ->get();
                        @endphp

                        @if($recentMovements->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentMovements as $movement)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 rounded-full {{ $movement->type == 'IN' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            @if($movement->type == 'IN')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $movement->product->nama_barang }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $movement->type == 'IN' ? 'Masuk' : 'Keluar' }} • 
                                                {{ $movement->qty }} {{ $movement->product->satuan }} • 
                                                {{ $movement->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold {{ $movement->type == 'IN' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $movement->type == 'IN' ? '+' : '-' }}{{ $movement->qty }}
                                        </p>
                                        <p class="text-xs text-gray-500">Stok: {{ $movement->stok_sesudah }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('stock.history') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                                    Lihat Semua Riwayat →
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Belum ada aktivitas</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stok Menipis -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">⚠️ Peringatan Stok Menipis</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $lowStockProducts = \App\Models\Product::where('stok', '<=', 10)
                                                ->where('stok', '>', 0)
                                                ->orderBy('stok', 'asc')
                                                ->limit(5)
                                                ->get();
                            $outOfStockProducts = \App\Models\Product::where('stok', '=', 0)->count();
                        @endphp

                        @if($outOfStockProducts > 0)
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <p class="text-sm font-semibold text-red-800">
                                    {{ $outOfStockProducts }} produk stok habis!
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($lowStockProducts->count() > 0)
                            <div class="space-y-3">
                                @foreach($lowStockProducts as $product)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $product->nama_barang }}</p>
                                        <p class="text-xs text-gray-500 font-mono">{{ $product->barcode }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $product->stok == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $product->stok }} {{ $product->satuan }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                                    Kelola Produk →
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p>Semua stok aman! ✓</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>