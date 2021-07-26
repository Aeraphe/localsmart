<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteEmployeeRequest;
use App\Http\Requests\EmployeeRegisterRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
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

    /**
     * Delete Employee
     *
     * @param DeleteEmployeeRequest $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function delete(DeleteEmployeeRequest $request)
    {
        try {
            $this->authorize('delete_employee');
            $validated = $request->validated();
            Employee::where('id', $validated['id'])->delete();
            return ApiResponseService::make("Funcionário excluido com sucesso!!!", 200, ['id' => $validated['id']]);
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * Update Employee
     *
     * @param UpdateEmployeeRequest $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function update(UpdateEmployeeRequest $request)
    {
        try {

            $this->authorize('update_employee');
            $validated = $request->validated();
            Employee::where('id', $validated['id'])->update($validated);

            return ApiResponseService::make('Dados atualizados com sucesso!!!', 200, ['id' => $validated['id']]);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);
        }
    }
}
