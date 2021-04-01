<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {  
    Route::get('/', [ProductController::class, 'index'] );
    Route::get('products/fetch',[ProductController::class, 'getProductsFromApi'])->name('products.fetch');
    Route::post('products/update/{product_id}',[ProductController::class, 'updateProductsFromApi'])->name('products.update');
});

Route::get('/pusher', function(){
    return view('pusher');
});

Auth::routes();

Route::get('/home', [ProductController::class, 'index'])->name('home');
