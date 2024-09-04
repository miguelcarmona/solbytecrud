<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CarController;

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

Route::get('/', [CarController::class, 'index']);

Route::resource('categories', CategoryController::class);
Route::get('cars/exportCsv', [CarController::class, 'exportCSV'])-> name('cars.exportCsv');
Route::resource('cars', CarController::class);
Route::delete('cars/{car}/images/{image}', [CarController::class, 'destroyGalleryImage'])-> name('cars.images.destroy');

Route::get('cars/exportCsv', [CarController::class, 'exportCsv'])->name('cars.exportCsv');
