<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('account')->group(function () {
    Route::post('/login', [LoginController::class, 'authenticateAccountUserWeb'])->name('auth-admin');
});

Route::post('/login/{account}/{store}', [LoginController::class, 'authenticateEmployeWeb'])->name('auth-employe');
