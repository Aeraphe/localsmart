<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $role = $user->roles->where('name', 'admin')->first()->name;
        $employeeId = Request::get('id');
        $employee = Employee::where('account_id', $user->account->id)
            ->where('id', $employeeId)
            ->first();

        //Admin User and employee are from same account
        if ($role === 'admin' && $employee) {

            return true;

            //The employe and user are same person
        } elseif ($employee->id === $user->id) {

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
            'id' => ['required', 'numeric'],
            'name' => ['nullable'],
            'phone' => ['nullable'],
            'address' => ['nullable'],
            'login_name' => ['nullable'],
            'email' => ['nullable'],
            'password' => ['nullable'],
        ];
    }
}
