<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicationController;
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

/* Route::get('/', [PublicationController::class, 'index'])->name('publication.index'); */

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/publications', PublicationController::class);


Route::middleware(['auth', 'verified'])->group(function () {

    /* pagina dell'utente quando effettua il login */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* pagina dei progetti  */
    Route::resource('projects', ProjectController::class);

    // CRUD Pubblicazioni
    /* Route::resource('publications', PublicationController::class); */

    // Profilo Utente
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
