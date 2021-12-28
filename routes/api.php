<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DiaryController;
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

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::prefix('diaries')->group(function(){
    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/',[DiaryController::class, 'index'])->name('diary.index');
        Route::post('/',[DiaryController::class, 'store'])->name('diary.store');
        Route::get('/{id}',[DiaryController::class, 'show'])->name('diary.show');
        Route::put('/{id}',[DiaryController::class, 'update'])->name('diary.update');
        Route::delete('/{id}',[DiaryController::class, 'destroy'])->name('diary.destroy');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
