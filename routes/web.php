<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\TaskController;
use App\Models\Comment;
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

Route::resource('/publication', PublicationController::class)->only(['index', 'show'])->names([
    'index' => 'publication.index',
    'show' => 'publication.show',
]);

Route::middleware(['auth', 'verified'])->group(function () {

    /* pagina dell'utente quando effettua il login */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* rotta accessibile a tutti */
    Route::resource('/project', ProjectController::class)->only(['index', 'show']);

    Route::resource('task', TaskController::class)->only(['show', 'edit', 'update']);
    Route::resource('/tasks/{task}/comments', CommentController::class);

    /* SOLO GLI UTENTI ADMIN E PROJECT MANAGER POSSO FARE DETERMINATE COSE */
    Route::middleware(['project.manager'])->group(function () {

        /* PROGETTO: modifica e cancellazione */
        Route::resource('project', ProjectController::class)->only(['edit', 'update', 'destroy']);

        /* Milestone: modifica e cancellazione  */
        Route::resource('milestones', MilestoneController::class)->only(['edit', 'update', 'destroy'])->parameters(['milestones' => 'milestone']);

        /* Allegati:eliminazione */
        Route::delete('/attachments/{attachment}', [ProjectController::class, 'destroyAttachment'])->name('attachment.destroy');

        /* Milestone: creazione e salvataggio */
        Route::get('/project/{project}/milestones/create', [MilestoneController::class, 'create'])->name('milestones.create');
        Route::post('/project/{project}/milestones', [MilestoneController::class, 'store'])->name('milestones.store');

        Route::get('/project/{project}/task/create', [TaskController::class, 'create'])->name('project.task.create');
        Route::post('/project/{project}/task', [TaskController::class, 'store'])->name('project.task.store');

        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        Route::delete('/publication/{publication}', [PublicationController::class, 'destroy'])->name('publication.destroy');
    });

    // Profilo Utente
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
