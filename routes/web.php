<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollingUnitController;
use App\Http\Controllers\LGAController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'show'])->name('welcome');
Route::get('/pollingresult', [PollingUnitController::class, 'showPolling'])->name('pollingresult');
Route::get('/lgaresult', [LGAController::class, 'show'])->name('lgaresult');
Route::get('/addpollingunit', [PollingUnitController::class, 'create'])->name('pu.create');
Route::post('/addpollingunit', [PollingUnitController::class, 'store'])->name('pu.store');
Route::get('/api/wards/{lga_id}', [PollingUnitController::class, 'getWards']);
