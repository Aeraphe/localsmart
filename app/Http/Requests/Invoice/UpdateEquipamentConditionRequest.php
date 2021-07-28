<?php

namespace App\Http\Requests\Invoice;

use App\Models\InvoiceEquipamentCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateEquipamentConditionRequest extends FormRequest
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

        $condition = InvoiceEquipamentCondition::find($id);

        $storeId = $condition->repairInvoice->store->id;

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
            'name' => ['nullable', 'string'],
        ];
    }
}
