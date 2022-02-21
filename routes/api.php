<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller; 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); 
});

Route::get('/get-attribute/{id?}', [Controller::class, 'getattributeandvalue']);
Route::get('/check-user/{mobile}/{role}', [Controller::class, 'checkuserbymobile']);
Route::get('/validate-otp/{otp}', [Controller::class, 'validateotp']);
Route::get('/get-category/{parentId}/{type}', [Controller::class, 'getchildbyparent']);
Route::get('/get-cities-from-state/{id}', [Controller::class, 'getcitiesfromstate']);
//Route::delete('/delete-product-image/{id}', [Controller::class, 'deleteProductImage']);
//Route::post('/home/addtocart', [Controller::class, 'addtocart']);


