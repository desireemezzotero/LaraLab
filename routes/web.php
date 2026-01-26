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

Route::get('/', [PublicationController::class, 'index'])->name('publication.index');
Route::get('/publications/{publication}', [PublicationController::class, 'show'])->name('publication.show');

Route::middleware(['auth', 'verified'])->group(function () {

    /* pagina dell'utente quando effettua il login */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* pagina dei progetti  */
    /*     Route::resource('project', ProjectController::class); */

    Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('project.show');

    /* SOLO GLI UTENTI ADMIN E PROJECT MANAGER POSSO FARE DETERMINATE COSE */

    Route::middleware(['project.manager'])->group(function () {
        /*        Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
        Route::post('/project', [ProjectController::class, 'store'])->name('project.store'); */

        /* modifica e salvataggio della modifica di un progetto */
        Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');

        /* eliminazione di un progetto */
        Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

        /* eliminazione dei documenti che ci sono in un progetto */
        Route::delete('/attachments/{attachment}', [ProjectController::class, 'destroyAttachment'])->name('attachment.destroy');
    });

    // CRUD Pubblicazioni
    /* Route::resource('publications', PublicationController::class); */

    // Profilo Utente
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
