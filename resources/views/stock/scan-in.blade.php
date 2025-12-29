<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan Barang Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Alert -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert" id="successAlert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold">
                            {{ session('success')['message'] }}
                        </p>
                        
                        @if(isset(session('success')['product']))
                        <div class="mt-3 bg-white p-4 rounded shadow-sm">
                            <h4 class="font-semibold text-gray-800 mb-2">Detail Transaksi:</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Barcode:</span>
                                    <span class="font-mono font-semibold ml-2">{{ session('success')['product']->barcode }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Nama Barang:</span>
                                    <span class="font-semibold ml-2">{{ session('success')['product']->nama_barang }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Qty Masuk:</span>
                                    <span class="font-semibold text-green-600 ml-2">
                                        +{{ session('success')['qty'] }} {{ session('success')['product']->satuan }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Stok Sebelum:</span>
                                    <span class="ml-2">{{ session('success')['stok_sebelum'] }}</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-600">Stok Sesudah:</span>
                                    <span class="font-bold text-blue-600 text-lg ml-2">
                                        {{ session('success')['product']->stok }} {{ session('success')['product']->satuan }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Error Alert -->
            @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert" id="errorAlert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold">Error!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Main Form Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('stock.scan-in.process') }}" id="scanForm" autocomplete="off">
                        @csrf
                        
                        <!-- Barcode Input -->
                        <div class="mb-6">
                            <label for="barcode" class="block text-sm font-bold text-gray-700 mb-2">
                                Scan Barcode <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="barcode" 
                                id="barcode" 
                                class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-2xl py-4 px-4 font-mono"
                                placeholder="Arahkan scanner ke barcode..."
                                autofocus
                                autocomplete="off"
                                required
                            >
                        </div>

                        <!-- Quantity Input -->
                        <div class="mb-6">
                            <label for="qty" class="block text-sm font-bold text-gray-700 mb-2">
                                Jumlah (Qty) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="qty" 
                                id="qty" 
                                value="1"
                                min="1"
                                step="1"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-lg py-3 px-4"
                                required
                            >
                            <p class="mt-1 text-xs text-gray-500">Default: 1 unit per scan</p>
                        </div>

                        <!-- Keterangan (Optional) -->
                        <div class="mb-8">
                            <label for="keterangan" class="block text-sm font-bold text-gray-700 mb-2">
                                Keterangan <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input 
                                type="text" 
                                name="keterangan" 
                                id="keterangan" 
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-3 px-4"
                                placeholder="Contoh: Restock, Pembelian baru, dll"
                            >
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <button 
                                type="submit" 
                                class="flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out transform hover:scale-105"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Proses Barang Masuk
                            </button>
                            
                            <div class="flex gap-3">
                                <a href="{{ route('stock.scan-out') }}" class="text-red-600 hover:text-red-800 font-semibold">
                                    Barang Keluar →
                                </a>
                                <a href="{{ route('stock.history') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Lihat Riwayat →
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Instructions Box -->
                    <div class="mt-8 p-5 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
                        <h4 class="font-bold text-green-900 mb-2">📋 Petunjuk Penggunaan Scanner:</h4>
                        <ul class="list-disc list-inside text-sm text-green-800 space-y-1">
                            <li>Pastikan cursor aktif di kolom <strong>"Scan Barcode"</strong></li>
                            <li>Arahkan barcode scanner ke produk yang ingin ditambahkan</li>
                            <li>Scanner akan otomatis membaca dan men-submit data</li>
                            <li>Tekan Enter jika scanner tidak otomatis mengirim Enter</li>
                            <li>Qty default adalah 1, ubah jika ingin menambah lebih banyak</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const barcodeInput = document.getElementById('barcode');
            const qtyInput = document.getElementById('qty');
            const scanForm = document.getElementById('scanForm');

            function focusBarcode() {
                barcodeInput.focus();
                barcodeInput.select();
            }

            focusBarcode();

            document.addEventListener('click', function(e) {
                const isInteractive = ['INPUT','BUTTON','A','SELECT','TEXTAREA'].includes(e.target.tagName);
                if (!isInteractive) setTimeout(focusBarcode, 100);
            });

            barcodeInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (this.value.trim() === '') {
                        alert('Barcode tidak boleh kosong!');
                        return;
                    }
                    scanForm.submit();
                }
            });

            scanForm.addEventListener('submit', function() {
                const submitBtn = scanForm.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                `;
            });

        });
    </script>
    @endpush
</x-app-layout>
