<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;

class UnsignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Request::user();
        $roleId = Request::get('role_id');
        $employeeId = Request::get('employee_id');
        $employees = $user->account->employees;

        $role = Role::find($roleId);

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
