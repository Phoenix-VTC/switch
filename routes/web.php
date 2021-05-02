<?php

use App\Http\Controllers\TrucksbookDataController;
use App\Http\Controllers\SteamAuthController;
use App\Http\Livewire\ImportStatusPage;
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

Route::view('/', 'home')->name('home');

Route::name('steps.')->group(function () {
    Route::view('start', 'steps.start')->name('start');

    Route::middleware('auth')->group(function () {
        Route::get('configure-trucksbook', [TrucksbookDataController::class, 'showTrucksbookIdentifierPage'])->name('configure-trucksbook');
        Route::post('configure-trucksbook', [TrucksbookDataController::class, 'findTrucksbookAccount'])->name('find-trucksbook-account');

        Route::get('confirm-jobs', [TrucksbookDataController::class, 'showConfirmJobsPage'])->name('confirm-jobs');
        Route::post('confirm-jobs', [TrucksbookDataController::class, 'startDataTransfer'])->name('start-data-transfer');
    });
});

Route::prefix('auth/steam')->name('auth.')->group(function () {
    Route::post('/', [SteamAuthController::class, 'redirectToSteam'])->name('steam');

    Route::name('steam.')->group(function () {
        Route::get('handle', [SteamAuthController::class, 'handle'])->name('handle');
        Route::get('logout', [SteamAuthController::class, 'logout'])->name('logout');
    });
});

Route::get('import-status/{uuid}', ImportStatusPage::class)->name('import-status');
