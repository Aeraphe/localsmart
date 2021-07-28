<?php

namespace App\Http\Requests\Store;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = Request::route('id');
        $user = Request::user();

        if ($user->hasRole('admin')) {
            return true;
        } elseif (Employee::find($user->id)->stores()->where('id', $id)->first()) {
          
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
