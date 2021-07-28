<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $account = Auth::user()->account;
        $stores = $account->stores()->count();

        //Check if account store has an equal slug
        $slug = Request::get('slug');
        $store = $account->stores()->where('slug', $slug)->first();
        if ($store) {

            throw new AuthorizationException("Login ($slug) da loja ja existe", 403);

        }

        //Check account store quantity not exceeds
        if ($stores < $account->store_qt) {

            return true;

        } else {

            throw new AuthorizationException('Total de Lojas atingiu o limite permitido pelo plano', 403);

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
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
        ];
    }
}
