<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [HomeController::class, 'index']);
Route::resource('data', DataController::class);
Route::get('/frekuensi', [DataController::class, 'frekuensi']);
Route::get('/statistik', [DataController::class, 'statistik']);
Route::get('/exportdata', [DataController::class, 'dataExport']);
Route::post('/importdata', [DataController::class, 'dataImport'])->name('importdata');
Route::get('/databergolong', [DataController::class, 'dataBergolong']);
Route::get('/chi', [DataController::class, 'chiKuadrat']);
Route::get('/lilliefors', [DataController::class, 'lilliefors']);
