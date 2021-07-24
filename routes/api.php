<?php

use App\Http\Controllers\AccountRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EquipamentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {return $request->user();});
});

Route::prefix('v1')->group(function () {

    Route::prefix('account')->group(function () {
        Route::post('/login', [LoginController::class, 'authenticateAccountUserApi'])->name('api-auth-admin');
        Route::post('/register', [AccountRegisterController::class, 'create'])->name('api-register-account');
        Route::middleware('auth:api')->post('/customer', [CustomerController::class, 'create'])->name('create-customer');
        Route::middleware('auth:api')->post('/employee', [EmployeeController::class, 'create'])->name('create-employee');
        Route::middleware('auth:api')->post('/customer/equipament', [EquipamentController::class, 'create'])->name('create-customer-equipament');
    });


    Route::post('/login/{account}/{store}', [LoginController::class, 'authenticateEmployeApi'])->name('api-auth-employe');
});
