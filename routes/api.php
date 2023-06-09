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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    Route::apiResource('album', \App\Http\Controllers\AlbumController::class);
    Route::get('images',[\App\Http\Controllers\ImageProcessingController::class,'index']);
    Route::get('images/album/{albumId}',[\App\Http\Controllers\ImageProcessingController::class,'getImagesByAlbum']);
    Route::get('image/{imageId}',[\App\Http\Controllers\ImageProcessingController::class,'show']);
    Route::post('image/resize',[\App\Http\Controllers\ImageProcessingController::class,'resize']);
    Route::delete('image/{image}',[\App\Http\Controllers\ImageProcessingController::class,'destroy']);
});
