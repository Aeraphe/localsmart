<?php

namespace App\Http\Requests\Invoice;

use App\Models\RepairInvoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateRepairStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Request::user();
        $id = Request::get('repair_invoice_id');
        $invoice = RepairInvoice::find($id);
        
        if ($user->account->stores()->where('id', $invoice->store_id)->first()) {
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
            'repair_invoice_id' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'status' => ['nullable'],
        ];
    }
}
