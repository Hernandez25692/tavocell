<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    VentaController,
    CierreDiarioController,
    ReparacionController,
    SeguimientoReparacionController,
    ConsultaReparacionController,
    ProductoController,
    InventarioController,
    ClienteController,
    FacturaController,
    FacturaProductoController,
    FacturaReparacionController
};

// Ruta raíz redirige al login
Route::get('/', fn() => redirect()->route('login'));

// Dashboard solo para autenticados
Route::get('/dashboard', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes y productos
    Route::resource('clientes', ClienteController::class);
    Route::resource('productos', ProductoController::class);

    // Inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');

    // Reparaciones
    Route::resource('reparaciones', ReparacionController::class);
    Route::post('/reparaciones/{reparacion}/facturar', [ReparacionController::class, 'facturar'])->name('facturar.reparacion');
    Route::post('/reparaciones/{reparacion}/abonar', [ReparacionController::class, 'abonar'])->name('reparaciones.abonar');

    // Seguimiento de reparaciones
    Route::get('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'index'])->name('seguimientos.index');
    Route::post('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'store'])->name('seguimientos.store');

    // Ventas
    Route::resource('ventas', VentaController::class);
    Route::get('ventas/{venta}/factura', [VentaController::class, 'descargarFactura'])->name('ventas.factura');

    // Cierres diarios
    Route::get('cierres', [CierreDiarioController::class, 'index'])->name('cierres.index');
    Route::post('cierres', [CierreDiarioController::class, 'store'])->name('cierres.store');

    // FACTURAS DE PRODUCTOS (POS)
    Route::prefix('facturas-productos')->group(function () {
        Route::get('/', [FacturaProductoController::class, 'index'])->name('facturas_productos.index');
        Route::get('/create', [FacturaProductoController::class, 'create'])->name('facturas_productos.create');
        Route::post('/', [FacturaProductoController::class, 'store'])->name('facturas_productos.store');
        Route::get('/{factura}', [FacturaProductoController::class, 'show'])->name('facturas_productos.show');
        Route::get('/{factura}/pdf', [FacturaProductoController::class, 'descargarPDF'])->name('facturas_productos.pdf');
    });

    Route::prefix('facturas-reparaciones')->group(function () {
        Route::get('/', [FacturaReparacionController::class, 'index'])->name('facturas_reparaciones.index');
        Route::get('/{factura}', [FacturaReparacionController::class, 'show'])->name('facturas_reparaciones.show');
        Route::get('/{factura}/pdf', [FacturaReparacionController::class, 'pdf'])->name('facturas_reparaciones.pdf');
        Route::delete('/{factura}', [FacturaReparacionController::class, 'destroy'])->name('facturas_reparaciones.destroy');
    });


    // Ruta clásica (opcional si mantienes la anterior)
    Route::resource('facturas', FacturaController::class);
    Route::get('/facturas/{factura}/pdf', [FacturaController::class, 'descargarPDF'])->name('facturas.pdf');
});

// Consulta pública de estado de reparación
Route::get('/estado-reparacion', [ConsultaReparacionController::class, 'index'])->name('consulta.reparacion');
Route::post('/estado-reparacion', [ConsultaReparacionController::class, 'buscar'])->name('consulta.buscar');

require __DIR__ . '/auth.php';
