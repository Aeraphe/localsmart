<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $account = Auth::user()->account;
        $id = Request::get('id');

        //Check if account store has an equal slug
        $slug = Request::get('slug');
        if ($slug) {
            $storeWithSameSlug = $account->stores()->where('slug', $slug)->first();
            if ($storeWithSameSlug) {

                throw new AuthorizationException("Login ($slug) da loja ja existe", 403);

            }
            //Check if user has store
            elseif ($account->stores()->where('id', $id)->first()) {

                return true;
            }
        };

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
            'slug' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
        ];
    }
}
