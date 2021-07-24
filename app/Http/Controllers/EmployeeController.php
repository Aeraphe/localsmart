<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRegisterRequest;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use App\Services\RegisterEmployeeService;
use Exception;

class EmployeeController extends Controller
{

    /**
     * Register new employee in the User Account
     *
     * @param EmployeeRegisterRequest $request
     * 
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function create(EmployeeRegisterRequest $request)
    {

        try {

            $this->authorize('create_employee');

            $data = $request->validated();

            $employee = RegisterEmployeeService::create($data);

            $responseData = ['name' => $employee->name, 'login' => $employee->login_name];

            return ApiResponseService::make('Funcionário criado com sucesso', 200, $responseData);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);
        }
    }
}
