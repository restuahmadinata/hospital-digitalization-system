<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineListController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PenjadwalanKonsultasiController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('user', UserListController::class)->except(['show'])->middleware('userlist');
    Route::resource('medicine', MedicineListController::class)->except(['show'])->middleware('medicinelist');
    Route::resource('medicalrecord', MedicalRecordController::class)->except(['show'])->middleware('medicalrecord');
    Route::resource('feedback', FeedbackController::class)->except(['show']);
    Route::resource('penjadwalan', PenjadwalanKonsultasiController::class)->except(['show']);
    
    Route::get('/penjadwalan/jadwal-dokter/{id_dokter}', [PenjadwalanKonsultasiController::class, 'getJadwalDokter'])->name('penjadwalan.jadwal-dokter');
    
    Route::post('penjadwalan/{id}/approve', [PenjadwalanKonsultasiController::class, 'approve'])->name('penjadwalan.approve');
    Route::get('/patient-list', [MedicalRecordController::class, 'patientsHandled'])->middleware('medicalrecord')->name('patientlist');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';