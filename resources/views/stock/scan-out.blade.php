<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan Barang Keluar') }}
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
                                    <span class="text-gray-600">Qty Keluar:</span>
                                    <span class="font-semibold text-red-600 ml-2">
                                        -{{ session('success')['qty'] }} {{ session('success')['product']->satuan }}
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
                    <form method="POST" action="{{ route('stock.scan-out.process') }}" id="scanForm" autocomplete="off">
                        @csrf
                        
                        <!-- Barcode Input -->
                        <div class="mb-6">
                            <label for="barcode" class="block text-sm font-bold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                    Scan Barcode
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input 
                                type="text" 
                                name="barcode" 
                                id="barcode" 
                                class="mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-2xl py-4 px-4 font-mono"
                                placeholder="Arahkan scanner ke barcode..."
                                autofocus
                                autocomplete="off"
                                required
                            >
                            @error('barcode')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity Input -->
                        <div class="mb-6">
                            <label for="qty" class="block text-sm font-bold text-gray-700 mb-2">
                                Jumlah (Qty)
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="qty" 
                                id="qty" 
                                value="1"
                                min="1"
                                step="1"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg py-3 px-4"
                                required
                            >
                            @error('qty')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4"
                                placeholder="Contoh: Pengiriman ke Toko A, Retur, dll"
                            >
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <button 
                                type="submit" 
                                class="flex items-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out transform hover:scale-105"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                                Proses Barang Keluar
                            </button>
                            
                            <div class="flex gap-3">
                                <a href="{{ route('stock.scan-in') }}" class="text-green-600 hover:text-green-800 font-semibold">
                                    Barang Masuk →
                                </a>
                                <a href="{{ route('stock.history') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Lihat Riwayat →
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Instructions Box -->
                    <div class="mt-8 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="font-bold text-blue-900 mb-2">📋 Petunjuk Penggunaan Scanner:</h4>
                                <ul class="list-disc list-inside text-sm text-blue-800 space-y-1">
                                    <li>Pastikan cursor aktif di kolom <strong>"Scan Barcode"</strong></li>
                                    <li>Arahkan barcode scanner ke kode barcode pada produk</li>
                                    <li>Scanner akan otomatis membaca dan mengirim data</li>
                                    <li>Tekan <kbd class="px-2 py-1 bg-white rounded border">Enter</kbd> untuk memproses (scanner otomatis mengirim Enter)</li>
                                    <li>Setelah berhasil, input akan otomatis clear dan siap scan berikutnya</li>
                                    <li>Ubah <strong>Qty</strong> sebelum scan jika ingin mengurangi lebih dari 1 unit</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Keyboard Shortcut Info -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-semibold text-gray-700 mb-2 text-sm">⌨️ Keyboard Shortcuts:</h5>
                        <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                            <div>
                                <kbd class="px-2 py-1 bg-white rounded border text-xs">Enter</kbd> 
                                <span class="ml-2">Submit form</span>
                            </div>
                            <div>
                                <kbd class="px-2 py-1 bg-white rounded border text-xs">Esc</kbd> 
                                <span class="ml-2">Clear barcode</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats (Optional) -->
            <div class="mt-6 grid grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold text-gray-700">{{ \App\Models\Product::sum('stok') }}</div>
                    <div class="text-sm text-gray-500">Total Stok</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold text-gray-700">{{ \App\Models\Product::count() }}</div>
                    <div class="text-sm text-gray-500">Total Produk</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <div class="text-2xl font-bold text-red-600">
                        {{ \App\Models\StockMovement::where('type', 'OUT')->whereDate('created_at', today())->sum('qty') }}
                    </div>
                    <div class="text-sm text-gray-500">Keluar Hari Ini</div>
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
            
            // ========================================
            // AUTO-FOCUS MANAGEMENT
            // ========================================
            function focusBarcode() {
                barcodeInput.focus();
                barcodeInput.select();
            }
            
            // Focus saat halaman pertama load
            focusBarcode();
            
            // Re-focus ketika user klik di area lain (bukan input/button)
            document.addEventListener('click', function(e) {
                const clickedElement = e.target;
                const isInteractiveElement = ['INPUT', 'BUTTON', 'A', 'SELECT', 'TEXTAREA'].includes(clickedElement.tagName);
                
                if (!isInteractiveElement) {
                    setTimeout(focusBarcode, 100);
                }
            });
            
            // ========================================
            // BARCODE SCANNER HANDLER
            // ========================================
            let scanBuffer = '';
            let scanTimeout;
            
            barcodeInput.addEventListener('keypress', function(e) {
                // Jika Enter ditekan, submit form
                if (e.key === 'Enter') {
                    e.preventDefault();
                    
                    // Validasi barcode tidak kosong
                    if (this.value.trim() === '') {
                        alert('Barcode tidak boleh kosong!');
                        return;
                    }
                    
                    // Submit form
                    scanForm.submit();
                }
            });
            
            // ========================================
            // FORM SUBMIT HANDLER
            // ========================================
            scanForm.addEventListener('submit', function(e) {
                // Trim barcode value
                barcodeInput.value = barcodeInput.value.trim();
                
                // Disable submit button untuk prevent double submit
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
            
            // ========================================
            // KEYBOARD SHORTCUTS
            // ========================================
            document.addEventListener('keydown', function(e) {
                // ESC = Clear barcode input
                if (e.key === 'Escape') {
                    barcodeInput.value = '';
                    focusBarcode();
                }
                
                // CTRL + Q = Focus ke qty input
                if (e.ctrlKey && e.key === 'q') {
                    e.preventDefault();
                    qtyInput.focus();
                    qtyInput.select();
                }
            });
            
            // ========================================
            // AUTO-HIDE ALERTS
            // ========================================
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                        focusBarcode();
                    }, 500);
                }, 5000);
            }
            
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.5s';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => {
                        errorAlert.remove();
                        focusBarcode();
                    }, 500);
                }, 7000); // Error lebih lama ditampilkan
            }
            
            // ========================================
            // BARCODE FORMAT VALIDATION (Optional)
            // ========================================
            barcodeInput.addEventListener('input', function(e) {
                // Hapus karakter non-alphanumeric jika perlu
                // this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
            });
            
            // ========================================
            // QUANTITY VALIDATION
            // ========================================
            qtyInput.addEventListener('change', function() {
                if (this.value < 1) {
                    this.value = 1;
                }
                if (this.value > 10000) {
                    this.value = 10000;
                    alert('Qty maksimal 10,000');
                }
            });
            
            console.log('✅ Scan OUT system initialized');
        });
    </script>
    @endpush
</x-app-layout>