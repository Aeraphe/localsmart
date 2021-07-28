<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
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
     
        if ($user->id == $id) {

            return true;

        } elseif ($user->hasRole('super-admin')) {

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
            'email' => ['email', 'nullable'],
        ];
    }
}
