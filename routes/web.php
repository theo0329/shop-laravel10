<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckUserController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ThirdPartyAuthController;

//use App\Http\Controllers\AuthController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

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

Route::get('/uud/{id}', [CheckUserController::class, 'show']);
Route::post('/uudd', [CheckUserController::class, 'index']);

route::get('/getCSRFToken', [HomeController::class, 'getCSRFToken']);

// FB 登入
Route::get('/auth/facebook-login', [LoginController::class, 'fbLogin'])->name('fb-login');
// FB 登入 callback
Route::get('/auth/facebook-login-callback', [LoginController::class, 'fbLoginCallback']);

Route::prefix('/auth')->group(function () {
    // 登入
    Route::get('/line-login', [ThirdPartyAuthController::class, 'redirectToProvider'])->name('line-login');
    // 第三方回傳
    Route::get('/line-login-callback', [ThirdPartyAuthController::class, 'callback']);
    // 登出
    Route::get('/line-logout', [ThirdPartyAuthController::class, 'logout']);
});
