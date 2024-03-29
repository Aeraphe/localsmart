<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\DeleteEmployeeRequest;
use App\Http\Requests\Employee\EmployeeRegisterRequest;
use App\Http\Requests\Employee\ShowEmployeeRequest;
use App\Http\Requests\Employee\SignedStoreRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use App\Services\RegisterEmployeeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Get employee by id
     *
     * @param Employee $employee
     * @param ShowEmployeeRequest $request
     * @return ApiResponseService || ApiResponseErrorService
     */
    public function show(Employee $employee, ShowEmployeeRequest $request)
    {
        try {
            $this->authorize('show_employee');
            return ApiResponseService::make('Consulta realizada com sucesso!!!', 200, $employee->toArray());
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * Get employee by id
     *
     * @param Employee $employee
     * @param ShowEmployeeRequest $request
     * @return ApiResponseService || ApiResponseErrorService
     */
    public function showAll()
    {
        try {

            $this->authorize('show_all_employee');

            $employee = Employee::where('account_id', Auth::user()->account->id)->get();

            return ApiResponseService::make('Consulta realizada com sucesso!!!', 200, $employee->toArray());
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    public function checkCredential(Request $request)
    {
        try {
            $this->authorize('create_employee');

            $validated = $request->validate(
                [
                    'login_name' => ['required', 'string'],
                ]
            );

            $user = $request->user();
            $employee = Employee::where('account_id', $user->account->id)->where('login_name', $validated['login_name'])->first();
            if ($employee == null) {
                return ApiResponseService::make('Login valido', 200, ['credential' => true]);
            } else {

                throw new Exception('Login já utilizado');
            }

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    public function changeStatus(Request $resquest)
    {
        try {
            $this->authorize('create_employee');
            $validated = $resquest->validate(
                [
                    'id' => ['required', 'numeric'],
                    'status' => ['required', 'string'],
                ]
            );

            $user = $resquest->user();

            Employee::where('account_id', $user->account->id)->where('id', $validated['id'])->update($validated);

            return ApiResponseService::make('Status modificado com sucesso!!', 200, $validated);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    public function showEmployeeStore(SignedStoreRequest $request)
    {
        try {
            $this->authorize('show_store_employee');
            $employee = Employee::find($request->route('employee'));
            $stores = $employee->stores->toArray();

            return ApiResponseService::make('Status modificado com sucesso!!', 200, $stores);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

}
