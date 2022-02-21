<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Controller; 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\SellerController; 
  



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


//GUEST ROUTES STARTS HERE
        // route that returns the website landing page 
Route::get('/', [FrontController::class, 'index'])->name('guest-home');
        // route for registration as a customer
Route::any('register', [FrontController::class, 'customerRegister'])->name('customer_register');
        // route for login as a customer
Route::any('login', [FrontController::class, 'customerLogin'])->name('customer_login');

        //supplier registration and login routes
Route::any('/supplier/get-mobile', [FrontController::class, 'getSupplierMobile'])->name('get-supplier-mobile');
Route::any('/supplier/get-details', [FrontController::class, 'getSupplierDetails'])->name('get-supplier-details');  
Route::any('/supplier/login', [FrontController::class, 'sellerLogin'])->name('seller_login');
        //supplier registration and login routes end

        //admin login route
Route::any('admin/login', [FrontController::class, 'adminLogin'])->name('admin-login');  
        //
        //UNCOMMENT THIS ROUTE TO REGISTER AS A ADMIN
// Route::any('admin/vowel/a/e/i/o/u/register', [FrontController::class, 'adminRegister'])->name('register-new-admin');
        //
        // routes to view products of website
Route::get('shop/product/single/{id?}',[FrontController::class , 'showSingle'])->name('single'); 
Route::get('shop/products/{gid}/{pid}/{cid}', [FrontController::class , 'products'])->name('products');
Route::get('shop/products', [FrontController::class , 'allProducts'])->name('all-products');  

//GUEST ROUTES ENDS HERE



//CUSTOMER AUTH ROUTES

Route::any('home', [HomeController::class, 'index'])->name('home');
Route::any('logout', [HomeController::class, 'logout'])->name('logout');
Route::any('home/address', [HomeController::class, 'address'])->name('address');
Route::get('home/orders', [HomeController::class, 'orders'])->name('orders');
Route::post('shop/addtocart', [HomeController::class, 'addtocart'])->name('addtocart');
Route::any('shop/cart', [HomeController::class, 'cart'])->name('cart');
Route::any('shop/checkout/details', [HomeController::class, 'checkoutDetails'])->name('checkout-details');
Route::get('shop/checkout/shipping', [HomeController::class, 'checkoutShipping'])->name('checkout-shipping');
Route::get('shop/checkout/review', [HomeController::class, 'checkoutReview'])->name('checkout-review');
Route::any('shop/checkout/payment', [HomeController::class, 'prePayment'])->name('checkout-payment');
Route::any('shop/checkout/payment-gateway', [HomeController::class, 'paymentGateway'])->name('payment-gateway');
Route::get('shop/checkout/complete', [HomeController::class, 'checkoutComplete'])->name('checkout-complete');
Route::get('shop/cart/delete-product/{id}', [HomeController::class, 'deleteCartProduct'])->name('delete-cart-product');

//CUSTOMER AUTH ROUTES END



//SUPPLIER AUTH ROUTES

Route::get('supplier', [SellerController::class, 'index'])->name('seller-home');
Route::get('supplier/upload-type', [SellerController::class, 'uploadType'])->name('seller-upload-type');
Route::any('supplier/logout', [SellerController::class, 'logout'])->name('seller_logout');
// Route::get('supplier/{page}', [SellerController::class, 'innerPages'])->name('supplier-pages');
Route::any('supplier/products/choose-category/{type?}', [SellerController::class, 'chooseCategory'])->name('choose_category');
Route::get('supplier/products', [SellerController::class, 'products'])->name('supplier_products');
Route::any('supplier/products/add-product', [SellerController::class, 'addProduct'])->name('add-product');
Route::any('supplier/products/edit-product/{id}', [SellerController::class, 'addProduct'])->name('edit-product');
Route::any('supplier/products/delete-product/{id}', [Controller::class, 'deleteProduct'])->name('delete-product');
Route::get('supplier/payouts', [SellerController::class, 'payouts'])->name('seller-payouts');
Route::get('supplier/orders/{type}', [SellerController::class, 'orders'])->name('seller-orders');
Route::post('supplier/move-to-complete-order', [SellerController::class, 'moveToCompleteOrder'])->name('move-to-complete-order');
Route::any('supplier/my-account', [SellerController::class, 'account'])->name('seller-account');
Route::get('supplier/settings', [SellerController::class, 'settings'])->name('seller-settings');
Route::get('supplier/purchases', [SellerController::class, 'purchases'])->name('seller-purchases');
Route::get('supplier/favorites', [SellerController::class, 'favorites'])->name('seller-favorites');

//SUPPLIER AUTH ROUTES END



 

//ADMIN AUTH ROUTES
Route::get('admin', [AdminController::class, 'index'])->name('admin');

Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin-logout');

Route::match(['get', 'post'], '/admin/user/add-user/{type}', [AdminController::class, 'addUser'])->name('admin-add-user');

Route::get('/admin/user/edit/{type}/{id}', [AdminController::class, 'addUser'])->name('admin-edit-user');

Route::get('/admin/attributes/all-attributes', [AdminController::class, 'showAttributes'])->name('admin-show-attributes');

Route::match(['get', 'post'], '/admin/add_attribute/{edit_id?}', [AdminController::class, 'AddAttribute'])->name('add_attribute');

Route::match(['get', 'post'], '/admin/add_attribute_values/{edit_id?}', [AdminController::class, 'AddAttributeValues'])->name('add_attribute_values');

Route::get('/admin/attributes/all-attribute-values', [AdminController::class, 'showAttributeValues'])->name('admin-show-attribute-values');

Route::get('/admin/orders/all-orders',[AdminController::class, 'allOrders'])->name('admin-orders');
Route::get('/admin/payments/all-payments',[AdminController::class, 'allPayments'])->name('admin-payments');

Route::post('/admin/verify_user',[AdminController::class, 'verifyUser']
)->name('verify_user');

Route::get('/admin/users/{type?}',[AdminController::class, 'showUser']
)->name('admin-show-users');

Route::get('/admin/users/view-user/{id}',[AdminController::class, 'viewUser']
)->name('admin-view-user'); 

Route::get('/admin/categories/all-categories', [AdminController::class, 'showCategory'])->name('admin-all-categories');

Route::match(['get', 'post'], '/admin/add_category/{edit_id?}', [AdminController::class, 'AddCategory'])->name('add_category');

Route::match(['get', 'post'], '/admin/add-ad-banner/{edit_id?}', [AdminController::class, 'addAdBanner'])->name('add_ad_banner');
Route::get('/admin/products/all-products', [AdminController::class, 'showProduct'])->name('admin-all-products');

Route::match(['get', 'post'], '/admin/select_category', [AdminController::class, 'showProductCategories'])->name('showProductCategories');

Route::match(['get', 'post'], '/admin/add-product', [AdminController::class, 'addProduct'])->name('add_product');

Route::any('/admin/edit-product/{edit_id?}', [AdminController::class, 'addProduct'])->name('edit_product');

Route::any('admin/products/delete-product/{id}', [Controller::class, 'deleteProduct'])->name('delete_product');

Route::get('/admin/remove/{type}/{id}', [Controller::class, 'delete'])->name('admin-remove');

//ADMIN AUTH ROUTES END


// EXTRA ROUTES

Route::get('/admin/invoices', function(){ 
    return view('admin.invoices');
})->name('admin-invoices');

Route::get('/admin/invoices/invoice', function(){
    return view('admin.invoice');
})->name('admin-invoice');

// EXTRA ROUTES END 




require __DIR__.'/auth.php';
