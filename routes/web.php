<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SantriController;
use App\Http\Controllers\MasterPelanggaranController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterLevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/dashboard/data', [PelanggaranController::class, 'getDashboardData'])->name('dashboard');
Route::get('/dashboard/data-user', [UserController::class, 'getDashboardData'])->name('dashboard');
Route::get('/dashboard/data-santri', [SantriController::class, 'getDashboardData'])->name('dashboard');
Route::get('/dashboard/data-pelanggaran', [PelanggaranController::class, 'getPelanggaranData'])->name('dashboard');
Route::get('/dashboard/data-permission', [PermissionController::class, 'getPermissionData'])->name('dashboard');
Route::get('/dashboard/data-bar', [PelanggaranController::class, 'getBarChartData']);
Route::get('/dashboard/top-santri', [DashboardController::class, 'topSantri']);
Route::get('/top-troublesome-santri', [PelanggaranController::class, 'topTroublesomeSantri']);
Route::get('/santri/profil/{id}', [DashboardController::class, 'profil'])->name('santri.profil');
Route::get('/send-wa/{id}', [SantriController::class, 'sendWhatsApp'])->name('send-wa');



Route::resource('master_level', MasterLevelController::class);



Route::resource('santri', SantriController::class);

Route::get('/santri/{id}', [SantriController::class, 'show'])->name('santri.show');
Route::get('/santri/{id}/report', 'SantriController@report')->name('santri.report');
// Route::get('santri/{id}/report', [SantriController::class, 'generateReport'])->name('santri.report');
Route::post('/santri/{id}/cetak-laporan', [SantriController::class, 'cetakLaporan'])->name('santri.cetakLaporan');
Route::get('/santri/{id}/laporan', 'SantriController@laporan')->name('santri.laporan');
Route::get('/santri/profil/{id}', [SantriController::class, 'profil'])->name('santri.profil');
Route::get('santri/{id}/profil', [SantriController::class, 'laporan'])->name('santri.profil');





Route::get('/pelanggaran/harian', [PelanggaranController::class, 'index'])->name('pelanggaran.harian.index');
Route::get('/pelanggaran/bulanan', [PelanggaranController::class, 'index2'])->name('pelanggaran.bulanan.index');
Route::get('/pelanggaran/input', [PelanggaranController::class, 'tambahindex'])->name('pelanggaran.tambah.index');
Route::post('/pelanggaran/toggle-status/{id}', [PelanggaranController::class, 'toggleStatus'])->name('pelanggaran.toggleStatus');

Route::post('/pelanggaran/store', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
Route::get('/pelanggaran/edit/{id}', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
Route::put('/pelanggaran/update/{id}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
Route::delete('/pelanggaran/delete/{id}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
Route::get('laporan/pelanggaran', [PelanggaranController::class, 'laporan'])->name('laporan.pelanggaran');


Route::middleware(['log.activity'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/activity-logs', [UserController::class, 'showActivityLogs'])->name('users.activity.logs');
});



Route::middleware(['auth'])->group(function () {
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('profile/{id}', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/change-password/{id}', [UserController::class, 'changePassword'])->name('profile.change-password');
});


// Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
// Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
// Route::put('/profile/password', [UserController::class, 'changePassword'])->name('profile.password');


// Route::get('password/reset', [UserController::class, 'showForgotPasswordForm'])->name('password.request');
// Route::post('password/reset', [UserController::class, 'sendResetLink'])->name('password.reset.link');
// Route::get('password/reset/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [UserController::class, 'resetPassword'])->name('password.update');


Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login/proses', 'proses');
    Route::post('logout', 'logout')->name('logout');
    
});
Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');

Route::resource('master_pelanggaran', MasterPelanggaranController::class);
Route::resource('permissions', PermissionController::class);
Route::post('permissions/mark-returned', [PermissionController::class, 'markReturned'])->name('permissions.markReturned');
Route::post('/permissions/update-status', [PermissionController::class, 'updateStatus'])->name('permissions.updateStatus');
Route::get('/dashboard/data-permission', [PermissionController::class, 'getDashboardData'])->name('dashboard');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    
    Route::get('dashboard', function () {
        return view('dashboard');
    });
  

    Route::resource('kelas', KelasController::class);

    Route::get('test', function () {
        return view('layout.main');
    });

    Route::get('pembayaran', function () {
        return view('pembayaran');
    });
    
    // Route::get('santri', function () {
    //     return view('santri.index');
    // })->name('santri.index');

    Route::get('pengurus', function () {
        return view('pengurus.index');
    });

    // Admin
    Route::group(['middleware' => ['checkRole:1']], function () {
        Route::get('dashboard', function () {
            return view('dashboard');
        });
    });

    // Pengurus
    Route::group(['middleware' => ['checkRole:2']], function () {
    });

    // Pengasuh
    Route::group(['middleware' => ['checkRole:3']], function () {
    });
});



