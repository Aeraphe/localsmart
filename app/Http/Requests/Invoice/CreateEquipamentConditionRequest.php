<?php

namespace App\Http\Requests\Invoice;

use App\Models\RepairInvoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateEquipamentConditionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Request::user();
        $invoiceId = Request::get('repair_invoice_id');
        $store = RepairInvoice::find($invoiceId);
   
        if ($user->stores()->where('id', $store->id)->first()) {
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
            'name' => ['required'],
            'equipament_id' => ['required', 'numeric'],
            'repair_invoice_id' => ['required', 'numeric'],
        ];
    }
}
