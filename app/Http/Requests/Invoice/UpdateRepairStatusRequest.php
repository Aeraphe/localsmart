<?php

namespace App\Http\Requests\Invoice;

use App\Models\RepairInvoiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateRepairStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Request::user();
        $id = Request::get('id');
        $status = RepairInvoiceStatus::with('repairInvoice')->find($id);

        if ($user->account->stores()->where('id', $status->repairInvoice->store_id)->first()) {
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
            'description' => ['required'],
            'status' => ['nullable'],
        ];
    }
}
