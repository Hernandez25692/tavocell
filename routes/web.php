<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CierreDiarioController;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\SeguimientoReparacionController;
use App\Http\Controllers\ConsultaReparacionController;
use App\Http\Controllers\ProductoController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('ventas', VentaController::class);
    Route::get('ventas/{venta}/factura', [VentaController::class, 'descargarFactura'])->name('ventas.factura');
    Route::get('cierres', [CierreDiarioController::class, 'index'])->name('cierres.index');
    Route::post('cierres', [CierreDiarioController::class, 'store'])->name('cierres.store');
    Route::resource('reparaciones', ReparacionController::class);
    Route::get('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'index'])->name('seguimientos.index');
    Route::post('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'store'])->name('seguimientos.store');
    Route::resource('productos', ProductoController::class)->middleware('auth');
    Route::resource('productos', ProductoController::class);
    
});
Route::get('/estado-reparacion', [ConsultaReparacionController::class, 'index'])->name('consulta.reparacion');
Route::post('/estado-reparacion', [ConsultaReparacionController::class, 'buscar'])->name('consulta.buscar');

require __DIR__.'/auth.php';
