<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $employee = Request::route('employee');
        $role = $user->roles->where('name', 'admin')->first()->name;

        //If user is admin and employe and user are from same account
        if ($role === 'admin' && $employee->account->id == $user->account->id) {
            return true;
            //If employee and user are the same person
        } elseif ($employee->id == $user->id) {
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
            //
        ];
    }
}
