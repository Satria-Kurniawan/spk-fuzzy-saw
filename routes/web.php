<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\FuzzyController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SAWController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {
    Route::get('/', [SAWController::class, 'getDataInfo'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/kriteria/data', [KriteriaController::class, 'getKriteriaData'])->name('kriteria.data');
    Route::post('/kriteria/add', [KriteriaController::class, 'addKriteria'])->name('kriteria.add');
    Route::post('/kriteria/update/{id}', [KriteriaController::class, 'updateKriteria'])->name('kriteria.update');
    Route::post('/kriteria/delete/{id}', [KriteriaController::class, 'deleteKriteria'])->name('kriteria.delete');

    Route::get('/fuzzy/data', [FuzzyController::class, 'getFuzzyData'])->name('fuzzy.data');
    Route::post('/fuzzy/add/{id_kriteria}', [FuzzyController::class, 'addFuzzy'])->name('fuzzy.add');
    Route::post('/fuzzy/update/{id_kriteria}/{id_fuzzy}', [FuzzyController::class, 'updateFuzzy'])->name('fuzzy.update');
    Route::post('/fuzzy/delete/{id_fuzzy}', [FuzzyController::class, 'deleteFuzzy'])->name('fuzzy.delete');

    Route::get('/alternatif/data', [AlternatifController::class, 'getAlternatifData'])->name('alternatif.data');
    Route::post('/alternatif/add', [AlternatifController::class, 'addAlternatif'])->name('alternatif.add');
    Route::post('/alternatif/update/{id}', [AlternatifController::class, 'updateAlternatif'])->name('alternatif.update');
    Route::post('/alternatif/delete/{id}', [AlternatifController::class, 'deleteAlternatif'])->name('alternatif.delete');

    Route::get('/perhitungan/data', [SAWController::class, 'getDataPerhitungan'])->name('perhitungan.data');
    Route::get('/perankingan/data', [SAWController::class, 'getDataPerankingan'])->name('perankingan.data');
});

require __DIR__.'/auth.php';
