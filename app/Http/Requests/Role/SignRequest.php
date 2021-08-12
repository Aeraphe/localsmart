<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;

class SignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Check if the role is type invoice and
     * role is app default or user created and
     * user account has the employee
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Request::user();
        $roleId = Request::get('role_id');
        $employeeId = Request::get('employee_id');
        $employees = $user->account->employees;
        $role = Role::findById($roleId);

   
        if (
            $role->module === 'invoice' &&
            ($role->account_id === null || $role->account_id === $user->account->id) &&
            $employees->firstWhere('id', $employeeId)
        ) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => ['required', 'numeric'],
            'role_id' => ['required', 'numeric'],
        ];
    }
}
