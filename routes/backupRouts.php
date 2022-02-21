<?php
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Controller; 
use App\Http\Controllers\AdminController; 
use Facade\Auth;

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
 
Route::get('/', [FrontController::class, 'index'])->name('guest-home');
Route::any('home/{type?}', [HomeController::class, 'costumerSignup'])->name('home');
Route::any('home/{type?}/{page?}', [HomeController::class, 'index'])->name('home2');

Route::get('product/left-sidebar', function(){
    return view('shop.grid-left');
})->name('grid-left');

Route::get('product/right-sidebar', function(){
    return view('shop.grid-right');
})->name('grid-right');
Route::get('product/top-filter', function(){
    return view('shop.grid-top');
})->name('grid-top');

Route::get('product/single1', function(){
    return view('shop.single1');
})->name('single1');

Route::get('product/single/{id?}',[FrontController::class , 'showSingle'])->name('single');

Route::get('shop/checkout/details', function(){
    return view('shop.checkout-details');
})->name('checkout-details');

Route::get('shop/checkout/shipping', function(){
    return view('shop.checkout-shipping');
})->name('checkout-shipping');

Route::get('shop/checkout/payment', function(){
    return view('shop.checkout-payment');
})->name('checkout-payment');

Route::get('shop/checkout/review', function(){
    return view('shop.checkout-review');
})->name('checkout-review');

Route::get('shop/checkout/complete', function(){
    return view('shop.checkout-complete');
})->name('checkout-complete');

Route::get('shop/order/track-order', function(){
    return view('shop.order-tracking');
})->name('order-tracking');


//Admin.......................
Route::get('admin', function(){
    return view('admin.dashboard');
})->name('admin');

Route::get('/admin/orders', function(){
    return view('admin.orders');
})->name('admin-orders');

Route::get('/admin/invoices', function(){ 
    return view('admin.invoices');
})->name('admin-invoices');

Route::get('/admin/invoices/invoice', function(){
    return view('admin.invoice');
})->name('admin-invoice');




Route::get('/admin/user/add-user', function(){
    return view('admin.add-user');
})->name('admin-add-user');  
 


Route::get('/admin/products/add-product/{mode?}/{id?}', [ProductController::class, 'ProductForm'])->name('admin-add-product');

Route::post('/admin/products/add-product/save-product/{mode?}/{id?}', [ProductController::class, 'saveProduct'])->name('admin-save-product');

Route::get('/admin/remove/{type}/{id}', [Controller::class, 'delete'])
->name('admin-remove'); 

Route::any('/admin/categories/add-category/update/{id?}', [CategoryController::class, 'UpdateCategory'])->name('update_category');


// AMDIN CONTROLS

// USER CONTROL
Route::get('/admin/users/{type?}',[AdminController::class, 'showUser']
)->name('admin-show-users');

// CATEGORY CONTROL 
Route::get('/admin/categories/all-categories', [AdminController::class, 'showCategory'])
->name('admin-all-categories');

Route::match(['get', 'post'], '/admin/add_category/{edit_id?}', [AdminController::class, 'AddCategory'])
->name('add_category');

// PRODUCT CONTROL
Route::get('/admin/products/all-products', [AdminController::class, 'showProduct'])->name('admin-all-products');


Route::match(['get', 'post'], '/admin/add_prroduct/{edit_id?}', [AdminController::class, 'AddProduct'])->name('add_product');

// ATTRIBUTE CONTROL.........

Route::get('/admin/attributes/all-attributes', [AdminController::class, 'showAttributes'])->name('admin-show-attributes');

Route::match(['get', 'post'], '/admin/add_attribute/{edit_id?}', [AdminController::class, 'AddAttribute'])->name('add_attribute');
Route::match(['get', 'post'], '/admin/add_attribute_values/{edit_id?}', [AdminController::class, 'AddAttributeValues'])->name('add_attribute_values');


// SUPPLIRE CONTROLS

