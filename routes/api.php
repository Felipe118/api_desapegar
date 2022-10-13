<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
 
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
Route::post('/login', [AuthController::class,'login'])->name('api.login');
Route::post('/register', [UserController::class,'register'])->name('register');

Route::middleware('jwt.auth')->group(function(){
    Route::apiResource('categories',CategoryController::class);
    Route::apiResource('product',ProductController::class);
    Route::apiResource('address',AddressController::class);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/me', [AuthController::class,'me']);
    Route::post('/updateUser/{id}', [UserController::class, 'update']);
});

Route::get('/',function (){
    return response()->json(['message'=>'Welcome to API']);
});


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
