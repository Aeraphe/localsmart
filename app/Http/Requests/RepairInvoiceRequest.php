<?php

namespace App\Http\Requests;

use App\Models\Equipament;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        try {
            $store_id = Request::get('store_id');
            $equipament_id = Request::get('equipament_id');

            $store = Equipament::find($equipament_id)->customer->account->stores->where('id', $store_id)->first();
            //Check if the auth user can access the store
            $employeeFromStore = $store->employees->where('id', '=', Auth::user()->id)->first();

            if ($employeeFromStore) {
                return true;
            };
            return false;
        } catch (Exception) {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'store_id' => 'required',
            'customer_id' => 'required',
            'equipament_id' => 'required',
            'budget' => 'nullable',
            'conditions' => 'required',
            'inspections' => 'required',
            'fail_description' => 'required',
        ];
    }
}
