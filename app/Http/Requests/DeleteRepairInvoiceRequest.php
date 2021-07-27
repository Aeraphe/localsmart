<?php

namespace App\Http\Requests;

use App\Models\RepairInvoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteRepairInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $invoiceId = Request::get('id');
        $user = Auth::user();
        $invoice = RepairInvoice::find($invoiceId);
        $store = $user->stores->find($invoice->store_id);
        if ($store) {
            Request::route()->setParameter('invoice', $invoice);
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
            'id' =>['required','numeric'],
        ];
    }
}
