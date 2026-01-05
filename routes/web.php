<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Stock Scanning Routes
    Route::prefix('stock')->name('stock.')->group(function () {
        // Scan OUT (Barang Keluar)
        Route::get('/scan-out', [StockController::class, 'scanOutForm'])->name('scan-out');
        Route::post('/scan-out', [StockController::class, 'scanOutProcess'])->name('scan-out.process');
        
        // Scan IN (Barang Masuk)
        Route::get('/scan-in', [StockController::class, 'scanInForm'])->name('scan-in');
        Route::post('/scan-in', [StockController::class, 'scanInProcess'])->name('scan-in.process');
        
        // History
        Route::get('/history', [StockMovementController::class, 'index'])->name('history');
    });
    Route::get('/stock/history/export', [StockController::class, 'export'])
    ->name('stock.history.export')
    ->middleware('auth');

    // Product CRUD Routes
    Route::resource('products', ProductController::class);

  
    
});

require __DIR__.'/auth.php';