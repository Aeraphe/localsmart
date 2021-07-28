<?php

namespace App\Http\Requests\Invoice;

use App\Models\InvoiceEquipamemtInspection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateEquipamentInspectionRequest extends FormRequest
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

        $inspection = InvoiceEquipamemtInspection::find($id);

        $storeId = $inspection->repairInvoice->store->id;

        if ($user->stores->where('id', $storeId)->first()) {
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
            'name' => ['required'],

        ];
    }
}
