<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole; // ✅ Importación directa del middleware personalizado
use App\Http\Controllers\DashboardController;
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
    FacturaReparacionController,
    UsuarioController
};

Route::get('/', fn() => redirect()->route('login'));

Route::get('/dashboard', [DashboardController::class, 'mostrar'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ADMIN: acceso total
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('productos', ProductoController::class);
        Route::resource('clientes', ClienteController::class)->only(['index', 'create', 'store', 'edit', 'update']);
        Route::resource('facturas', FacturaController::class);
        Route::get('/facturas/{factura}/pdf', [FacturaController::class, 'descargarPDF'])->name('facturas.pdf');
        Route::get('cierres', [CierreDiarioController::class, 'index'])->name('cierres.index');
        Route::post('cierres', [CierreDiarioController::class, 'store'])->name('cierres.store');
        Route::post('/cierres/{id}/descargar', [CierreDiarioController::class, 'descargar'])->name('cierres.descargar');
        Route::post('/cierres/{id}/actualizar-efectivo', [CierreDiarioController::class, 'actualizarEfectivo'])->name('cierres.actualizarEfectivo');

        Route::resource('clientes', ClienteController::class);
        Route::resource('ventas', VentaController::class);
        Route::get('ventas/{venta}/factura', [VentaController::class, 'descargarFactura'])->name('ventas.factura');
        Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
        Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');

        Route::resource('reparaciones', ReparacionController::class);
        Route::post('/reparaciones/{reparacion}/facturar', [ReparacionController::class, 'facturar'])->name('facturar.reparacion');
        Route::post('/reparaciones/{reparacion}/abonar', [ReparacionController::class, 'abonar'])->name('reparaciones.abonar');
        Route::get('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'index'])->name('seguimientos.index');
        Route::post('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'store'])->name('seguimientos.store');

        Route::prefix('facturas-reparaciones')->group(function () {
            Route::get('/', [FacturaReparacionController::class, 'index'])->name('facturas_reparaciones.index');
            Route::get('/{factura}', [FacturaReparacionController::class, 'show'])->name('facturas_reparaciones.show');
            Route::get('/{factura}/pdf', [FacturaReparacionController::class, 'pdf'])->name('facturas_reparaciones.pdf');
            Route::delete('/{factura}', [FacturaReparacionController::class, 'destroy'])->name('facturas_reparaciones.destroy');
        });

        Route::prefix('facturas-productos')->group(function () {
            Route::get('/', [FacturaProductoController::class, 'index'])->name('facturas_productos.index');
            Route::get('/create', [FacturaProductoController::class, 'create'])->name('facturas_productos.create');
            Route::post('/', [FacturaProductoController::class, 'store'])->name('facturas_productos.store');
            Route::get('/{factura}', [FacturaProductoController::class, 'show'])->name('facturas_productos.show');
            Route::get('/{factura}/pdf', [FacturaProductoController::class, 'descargarPDF'])->name('facturas_productos.pdf');
        });
    });

    // CAJERO
    Route::middleware([CheckRole::class . ':cajero'])->group(function () {
        Route::resource('clientes', ClienteController::class)->only(['index', 'create', 'store', 'edit', 'update']);
        Route::resource('ventas', VentaController::class);
        Route::get('ventas/{venta}/factura', [VentaController::class, 'descargarFactura'])->name('ventas.factura');
        Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
        Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');

        Route::resource('reparaciones', ReparacionController::class);
        Route::post('/reparaciones/{reparacion}/facturar', [ReparacionController::class, 'facturar'])->name('facturar.reparacion');
        Route::post('/reparaciones/{reparacion}/abonar', [ReparacionController::class, 'abonar'])->name('reparaciones.abonar');
        Route::get('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'index'])->name('seguimientos.index');
        Route::post('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'store'])->name('seguimientos.store');
    });

    // TÉCNICO
    Route::middleware([CheckRole::class . ':tecnico'])->group(function () {
        Route::resource('reparaciones', ReparacionController::class);
        Route::post('/reparaciones/{reparacion}/facturar', [ReparacionController::class, 'facturar'])->name('facturar.reparacion');
        Route::post('/reparaciones/{reparacion}/abonar', [ReparacionController::class, 'abonar'])->name('reparaciones.abonar');
        Route::get('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'index'])->name('seguimientos.index');
        Route::post('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'store'])->name('seguimientos.store');
    });
});


// Rutas públicas
Route::get('/estado-reparacion', [ConsultaReparacionController::class, 'index'])->name('consulta.reparacion');
Route::post('/estado-reparacion', [ConsultaReparacionController::class, 'buscar'])->name('consulta.buscar');
Route::get('/reparacion/{id}/seguimiento', [ConsultaReparacionController::class, 'publica'])->name('consulta.reparacion.publica');

require __DIR__ . '/auth.php';
