<?php
use App\Http\Controllers\VaccinationSchedulerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VaccinationHistoryController;
use App\Http\Controllers\HealthProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [VaccinationSchedulerController::class, 'dashboard'])
         ->name('dashboard');
    Route::put('/profile', [VaccinationSchedulerController::class, 'updateProfile'])
         ->name('profile.update');
    Route::get('/vaccination/{vaccine}/schedule', [VaccinationSchedulerController::class, 'scheduleVaccination'])
         ->name('vaccination.schedule');
    Route::get('/vaccinations/due', [VaccinationSchedulerController::class, 'getDueVaccinations']);

    Route::get('/vaccinations', [VaccinationHistoryController::class, 'index'])->name('vaccinations.index');
    Route::get('/health-profile', [HealthProfileController::class, 'index'])->name('health-profile.index');
    Route::put('/health-profile', [HealthProfileController::class, 'update'])->name('health-profile.update');
    Route::get('/vaccination/{vaccination}/schedule', [VaccinationScheduleController::class, 'show'])
     ->name('vaccination.schedule');
     Route::post('/vaccination/{vaccination}/schedule', [VaccinationScheduleController::class, 'store'])
     ->name('vaccination.schedule.store');
});

Route::prefix('profile')->group(function () {
     Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
     Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
     Route::put('/health', [ProfileController::class, 'updateHealth'])->name('profile.health.update');
     Route::put('/emergency', [ProfileController::class, 'updateEmergency'])->name('profile.emergency.update');
     Route::put('/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications.update');
     Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
     Route::delete('/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
 });
