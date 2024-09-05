    <?php

use App\Http\Controllers\ProfileController;
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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [CarController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/categories', [CategoryController::class, 'index'])->middleware(['auth', 'verified']);


Route::middleware(['auth', 'role:ver,editar'])->group(function () {
    
    //Route::resource('categories', CategoryController::class)->only(['index']);
    Route::get('categories', [CategoryController    ::class, 'index'])-> name('categories.index');

    //Route::resource('cars', CarController::class)->only(['index', 'show', 'exportCsv']);
    Route::get('cars', [CarController::class, 'index'])-> name('cars.index');
    Route::get('cars/show/{car}', [CarController::class, 'show'])-> name('cars.show');
    Route::get('cars/exportCsv', [CarController::class, 'exportCSV'])-> name('cars.exportCsv');

});

Route::middleware(['auth', 'role:editar'])->group(function () {

    //Route::resource('categories', CategoryController::class)->only(['show','create','store','update','edit','destroy']);
    Route::get('categories/show ', [CategoryController::class, 'show'])-> name('categories.show');
    Route::get('categories/create ', [CategoryController::class, 'create'])-> name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])-> name('categories.store');
    Route::get('categories/{categories}/edit', [CategoryController::class, 'edit'])-> name('categories.edit');
    Route::put('categories/{categories}', [CategoryController::class, 'update'])-> name('categories.update');
    Route::delete('categories/{categories}', [CategoryController::class, 'destroy'])-> name('categories.destroy');

    //Route::resource('cars', CategoryController::class)->only(['create','store','update','edit','destroy']);
    Route::get('cars/create', [CarController::class, 'create'])-> name('cars.create');
    Route::post('cars', [CarController::class, 'store'])-> name('cars.store');
    Route::get('cars/{car}/edit', [CarController::class, 'edit'])-> name('cars.edit');
    Route::put('cars/{car}', [CarController::class, 'update'])-> name('cars.update');
    Route::delete('cars/{car}', [CarController::class, 'destroy'])-> name('cars.destroy');      
    Route::delete('cars/{car}/destroymainimage', [CarController::class, 'destroyMainImage'])-> name('cars.mainImage.destroy');
    Route::delete('cars/{car}/images/{image}', [CarController::class, 'destroyGalleryImage'])-> name('cars.images.destroy');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/*

Route::get('/', [CarController::class, 'index']);

Route::resource('categories', CategoryController::class);
Route::get('cars/exportCsv', [CarController::class, 'exportCSV'])-> name('cars.exportCsv');
Route::resource('cars', CarController::class);
Route::delete('cars/{car}/images/{image}', [CarController::class, 'destroyGalleryImage'])-> name('cars.images.destroy');

Route::get('cars/exportCsv', [CarController::class, 'exportCsv'])->name('cars.exportCsv');

*/ 