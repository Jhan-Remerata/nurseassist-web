<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\NursingNoteController;
use App\Http\Controllers\CareTaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (already protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patients
    Route::resource('patients', PatientController::class);

    // Vital Signs
    // Route::get('/vitals', [VitalSignController::class, 'index'])->name('vitals.index');
    // Route::put('/vitals/{id}', [VitalSignController::class, 'update'])->name('vitals.update');
    // Vital Signs
    Route::get('/vitals', [VitalSignController::class, 'index'])->name('vitals.index');
    Route::put('/vitals/{id}', [VitalSignController::class, 'update'])->name('vitals.update');


    // You can keep these blank view routes for now, or convert to controller later
    // Route::get('/notes', fn () => view('notes.index'))->name('notes.index');
    // Route::get('/tasks', fn () => view('tasks.index'))->name('tasks.index');
    // Route::get('/reports', fn () => view('reports.index'))->name('reports.index');
    Route::get('/about', fn () => view('about'))->name('about');

    // Nursing Notes
    Route::get('/notes', [NursingNoteController::class, 'index'])->name('notes.index');
    Route::put('/notes/{id}', [NursingNoteController::class, 'update']);
    Route::delete('/notes/{id}', [NursingNoteController::class, 'destroy']);
    Route::post('/notes', [NursingNoteController::class, 'store'])->name('notes.store');

    // CARE TASK SCHEDULER ROUTES
    Route::get('/tasks', [CareTaskController::class, 'index'])->name('tasks.index');              // Page showing patients
    Route::get('/care-tasks/{patient}', [CareTaskController::class, 'show'])->name('tasks.show'); // AJAX: fetch tasks
    Route::post('/care-tasks', [CareTaskController::class, 'store'])->name('tasks.store');        // AJAX: store task
    Route::post('/care-tasks/{careTask}', [CareTaskController::class, 'update'])->name('tasks.update'); // AJAX: update (using _method=PUT)
    Route::delete('/care-tasks/{careTask}', [CareTaskController::class, 'destroy'])->name('tasks.destroy'); // Delete (optional)

    //Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::delete('/reports/{patient}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

require __DIR__.'/auth.php';
