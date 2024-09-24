<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

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


Route::get('/', [CityController::class, 'index'])->name('cities.index');
Route::get('/reset-city', [CityController::class, 'resetCity'])->name('cities.reset');

Route::group(['prefix' => '{citySlug}'], function () {
    Route::get('/', [CityController::class, 'show'])->name('cities.show'); // Маршрут для отображения города
    Route::get('/about', [CityController::class, 'about'])->name('cities.about');
    Route::get('/news', [CityController::class, 'news'])->name('cities.news');
});


