<?php

namespace App\Http\Requests\Store;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class SignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Request::user();
        $storeId = Request::get('store_id');
        $employeeId = Request::get('employee_id');

        $userStore = $user->account->stores->firstWhere('id', $storeId);
        $employee = $user->account->employees->firstWhere('id', $employeeId);
      
   
        if ( $userStore && $employee) {
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
            'store_id' => ['required','numeric'],
            'employee_id' => ['required','numeric']
        ];
    }
}
