<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\SignRequest;
use App\Http\Requests\Role\UnsignRequest;
use App\Models\Employee;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Show all user Roles and App default Roles
     * App default roles account_id is null
     *
     * @param Request $request
     * @return ApiResponseService<Role>
     */
    public function showAll(Request $request)
    {
        try {
            $this->authorize('show_all_role');
            $user = $request->user();
            $roles = Role::where([
                ['module', '=', 'invoice'],
                ['guard_name', '=', 'api'],
                ['account_id', '=', null]])
                ->orWhere('account_id', $user->account->id)
                ->get();
            return ApiResponseService::make('Consulta Realizada com sucesso!!!', 200, $roles->toArray());
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * Sign Role to Employee
     *
     * @return void
     */
    public function sign(SignRequest $request)
    {
        try {
            $this->authorize('sign_role');
            $validated = $request->validated();
            $employee = Employee::find($validated['employee_id']);
            $role = Role::findById($validated['role_id']);
            $employee->assignRole($role->name);

            return ApiResponseService::make('Permissão atribuida com Sucesso!!!', 200, $validated);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

    /**
     * Show employee roles
     *
     * @param Employee $employee
     * @return ApiResponseService<Role>
     */
    public function show(Employee $employee)
    {
        try {
            $this->authorize('show_role');
            $roles = $employee->roles;

            return ApiResponseService::make('Consulta Realizada Com Sucesso!!!', 200, $roles->toArray());

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);
        }
    }

    public function unsign(UnsignRequest $request)
    {
        try {

            $this->authorize('unsign_role');
            $validated = $request->validated();
            $employee = Employee::find($validated['employee_id']);
            $role = Role::find($validated['role_id']);
            $employee->removeRole($role->name);

            return ApiResponseService::make('Tipo de acesso removido com Sucesso!!!', 200, $validated);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);
        }
    }
}
