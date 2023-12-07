<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CrawlerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShortUrlController;
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
    return redirect()->route('home');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function(){
    Route::controller(HomeController::class)->group(function(){
        Route::get('/home','index')->name('home');
        Route::get('/routes','routes')->name('routes');
        Route::prefix('runjob')->group(function(){
            Route::get('/pages','runPagesJob')->name('runPagesJob');
            Route::get('/images','runImagesJob')->name('runImagesJob');
        });
    });

    Route::controller(ShortUrlController::class)->name('shorts.')->group(function(){
        Route::get('/getAll','index')->name('index');
        Route::post('/store','store')->name('store');
    });

    Route::controller(PageController::class)->name('page.')->prefix('page')->group(function(){
        Route::get('/index/{limit?}','index')->name('index');
        Route::get('/show/{page?}','show')->name('show');
        Route::get('/findPending','findPending')->name('findPending');
    });

    Route::controller(ImageController::class)->name('image.')->prefix('image')->group(function(){
        Route::get('/ShowPending','ShowPending')->name('ShowPending');
        Route::get('/showAllImages','showAllImages')->name('showAllImages');
    });

    Route::controller(SettingController::class)->name('settings.')->prefix('settings')->group(function(){
        Route::get('/show','show')->name('show');
        Route::post('/update/{setting}','update')->name('update');
    });
});


/*
Route::controller(CrawlerController::class)->name('crawler.')->prefix('crawler')->group(function(){
    Route::get('/index','index')->name('index');
});

Busca y guarda paginas
http://scraper-jobs.dev.com/api/goutte/index

Recorre las paginas, crea los registros y se encola para crear imagenes y captura
http://scraper-jobs.dev.com/page/findPending

Recorre las imagenes faltantes para crear
http://scraper-jobs.dev.com/image/ShowPending
*/
