<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollingUnitController;
use App\Http\Controllers\LGAController;
use App\Http\Controllers\WelcomeController;

Route::get('/home', [WelcomeController::class, 'show'])->name('welcome');
Route::get('/pollingresult', [PollingUnitController::class, 'show'])->name('pollingresult');
Route::get('/lgresult', [LGAController::class, 'show'])->name('lgaresult');
