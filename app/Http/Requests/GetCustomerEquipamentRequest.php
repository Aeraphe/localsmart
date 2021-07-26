<?php

namespace App\Http\Requests;

use App\Models\Equipament;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetCustomerEquipamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accountId = Auth::user()->account->id;
        $equipamentId = Request::route('equipament');
        $equipament = Equipament::find($equipamentId);
        Request::route()->setParameter('equipament', $equipament);
       

        if ($equipament->customer->account_id == $accountId) {

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
            //
        ];
    }
}
