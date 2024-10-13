<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/
// routes/web.php

use App\Http\Controllers\ProductController;

Route::get( '/products', [ ProductController::class, 'index' ] )->name( 'products.index' );
Route::get( '/products/register', [ ProductController::class, 'create' ] )->name( 'products.register' );
Route::post( '/products/register/store', [ ProductController::class, 'store' ] )->name( 'products.store' );
Route::get( '/products/{product}', [ ProductController::class, 'show' ] )->name( 'products.show' );
Route::patch( '/products/{product}', [ ProductController::class, 'update' ] )->name( 'products.update' );
Route::delete( '/products/{product}', [ ProductController::class, 'destroy' ] )->name( 'products.destroy' );

