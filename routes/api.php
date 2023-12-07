<?php

use App\Http\Controllers\CustomCrawlerController;
use App\Http\Controllers\GoutteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(CustomCrawlerController::class)->name('crawler.')->prefix('crawler')->group(function(){
    Route::match(['get', 'post'],'crawl','fetchContent')->name('index');
});
Route::controller(GoutteController::class)->name('goutte.')->prefix('goutte')->group(function(){
    Route::match(['get', 'post'],'index','index')->name('index');
    Route::get('testPage','testPage')->name('testPage');
});
