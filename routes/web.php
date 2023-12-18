<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

route::get('dashboard', [CustomAuthController::class, 'dashboard']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::get('admin/product/new', [ProductController::class, 'newProduct'])->name('add-product');
Route::get('/store/products', [ProductController::class, 'index'])->name('products-store');
Route::get('admin/product/destroy/{id}', [ProductController::class, 'destroy']);
Route::POST('admin/product/save', [ProductController::class, 'add'])->name('product-save');

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/addProduct/{productId}', [CartController::class, 'addItem']);
Route::get('/removeItem/{productId}', [CartController::class, 'removeItem']);
Route::get('/cart', [CartController::class, 'showCart']);
<<<<<<< HEAD
=======

>>>>>>> 02bb12e7936ce13e74994cfb9dde9ae5d7c52985
Route::get('/carts', [CartController::class, 'showCart']);
