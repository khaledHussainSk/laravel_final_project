<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login',[\App\Http\Controllers\NewsController::class,'login']);
Route::get('/getNews',[\App\Http\Controllers\NewsController::class,'getNews']);
Route::get('/getAllCategories',[\App\Http\Controllers\CategoryController::class,'getAllCategories']);

Route::group(['middleware' => 'auth:api'],function() {
    Route::post('/addNews',[\App\Http\Controllers\NewsController::class,'store']);
    Route::post('/updateNews/{id}',[\App\Http\Controllers\NewsController::class,'update']);
    Route::delete('/deleteNews/{id}',[\App\Http\Controllers\NewsController::class,'destroy']);
    Route::post('/addCategory',[\App\Http\Controllers\CategoryController::class,'store']);
    Route::post('/updateCategory/{id}',[\App\Http\Controllers\CategoryController::class,'update']);
    Route::delete('/deleteCategory/{id}',[\App\Http\Controllers\CategoryController::class,'destroy']);
});

