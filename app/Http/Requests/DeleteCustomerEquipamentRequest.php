<?php

namespace App\Http\Requests;

use App\Models\Equipament;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteCustomerEquipamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $equipamentId = Request::get('id');
        $accountId = Auth::user()->account->id;
        $equipament = Equipament::find($equipamentId);

        if ($accountId === $equipament->customer->account_id) {

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
        ];
    }
}
