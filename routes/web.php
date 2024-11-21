<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineListController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/user-list', [UserListController::class, 'index'])
    ->middleware('userlist')
    ->name('userlist');

    Route::get('/medicine-list', [MedicineListController::class, 'index'])
    ->middleware('medicinelist')
    ->name('medicinelist');

    Route::get('/medical-record', [MedicalRecordController::class, 'index'])
    ->middleware('medicalrecord')
    ->name('medicalrecord');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
