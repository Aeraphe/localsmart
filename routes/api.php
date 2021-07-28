<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EquipamentController;
use App\Http\Controllers\RepairInvoiceController;
use App\Http\Controllers\StoreController;
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

Route::prefix('v1')->group(function () {

    //Unprotected Routes
    Route::prefix('account')->group(function () {
        Route::post('/login', [LoginController::class, 'authenticateAccountUserApi'])->name('api-auth-admin');
        Route::post('/register', [AccountController::class, 'create'])->name('api-register-account');
    });

    //Employee Loggin
    Route::post('/login/{account}/{store}', [LoginController::class, 'authenticateEmployeApi'])->name('api-auth-employe');

    //Protected Routes
    Route::middleware('auth:api')->group(function () {

        Route::prefix('account')->group(function () {

            //Account
            Route::put('/', [AccountController::class, 'update'])->name('update-account');
            Route::get('/', [AccountController::class, 'show'])->name('get-account');

            //Customer
            Route::post('/customer', [CustomerController::class, 'create'])->name('create-customer');
            Route::delete('/customer', [CustomerController::class, 'delete'])->name('delete-customer');
            Route::put('/customer', [CustomerController::class, 'update'])->name('update-customer');
            Route::get('/customer/paginate', [CustomerController::class, 'showPerPaginate'])->name('show-customer-paginate');
            Route::get('/customer/{customer}', [CustomerController::class, 'show'])->name('show-customer');
            Route::get('/customer', [CustomerController::class, 'showAll'])->name('show-all-customer');

            //Employee
            Route::post('/employee', [EmployeeController::class, 'create'])->name('create-employee');
            Route::delete('/employee', [EmployeeController::class, 'delete'])->name('delete-employee');
            Route::put('/employee', [EmployeeController::class, 'update'])->name('update-employee');
            Route::get('/employee/{employee}', [EmployeeController::class, 'show'])->name('show-employee');
            Route::get('/employee', [EmployeeController::class, 'showAll'])->name('show-employee');

            //Equipament
            Route::post('/customer/equipament', [EquipamentController::class, 'create'])->name('create-customer-equipament');
            Route::get('/customer/equipament/{equipament}', [EquipamentController::class, 'show'])->name('show-customer-equipament');
            Route::get('/customer/equipament/all/{customer}', [EquipamentController::class, 'showAll'])->name('show--all-customer-equipament');
            Route::put('/customer/equipament', [EquipamentController::class, 'update'])->name('update-customer-equipament');
            Route::delete('/customer/equipament', [EquipamentController::class, 'delete'])->name('delete-customer-equipament');
        });

        //Store
        Route::prefix('store')->group(function () {

            Route::post('/', [StoreController::class, 'create'])->name('create-store');
            Route::delete('/', [StoreController::class, 'delete'])->name('delete-store');
            Route::put('/', [StoreController::class, 'update'])->name('update-store');
            Route::get('/', [StoreController::class, 'showAll'])->name('show-all-store');
            Route::get('/{id}', [StoreController::class, 'show'])->name('show-store');

            //RepairInvoice
            Route::prefix('repair-invoice')->group(function () {
                Route::post('/', [RepairInvoiceController::class, 'create'])->name('store-create-repair-invoice');
                Route::put('/', [RepairInvoiceController::class, 'update'])->name('store-update-repair-invoice');
                Route::delete('/', [RepairInvoiceController::class, 'delete'])->name('store-delete-repair-invoice');
                Route::get('/all/{id}', [RepairInvoiceController::class, 'showAll'])->name('store-show--all-repair-invoice');
                Route::get('/{id}', [RepairInvoiceController::class, 'show'])->name('store-show-repair-invoice');
            });

        });

    });

});
