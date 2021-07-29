<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $customerId = Request::get('id');
        $employee = Auth::user();
   

        //Check customer from same account than employee
        $customer = $employee->account->customers->where('id', '=', $customerId)->first();


        if ($customer) {
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
            'id' => ['required'],
            'name' => ['nullable'],
            'address' => ['nullable'],
            'cpf' => ['nullable'],
            'rg' => ['nullable'],
            'phone' => ['nullable'],
            'city' => ['nullable'],
            'state' => ['nullable'],
            'district' => ['nullable'],
            'obs' => ['nullable'],
        ];
    }
}
