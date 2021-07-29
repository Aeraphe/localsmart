<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $customerId = Request::get('id');
        $storeId = Request::get('store_id');

        $employee = Auth::user();

        //Check if employee is from same store from givem store_id
        $store = $employee->stores->where('id', '=', $storeId)->first();
        
        //Check customer from same account than employee
        $customer = $employee->account->customers->where('id', '=', $customerId)->first();

      

        if ($store && $customer) {
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
            'store_id' => ['required', 'numeric'],
        ];
    }
}
