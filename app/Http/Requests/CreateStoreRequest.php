<?php

namespace App\Http\Requests;

use App\Exceptions\BaseException;
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
            
            $ex = new BaseException("Login ($slug) da loja ja existe", 403);
            $ex->setData(['slug' => 'data already exists for this account']);
            throw $ex;
          
        }

        //Check account store quantity not exceeds
        if ($stores < $account->store_qt) {

            return true;

        } else {

            $ex = new BaseException("O total de lojas permitidas pelo plano foi excedido", 403);
            $ex->setData(['store' => 'Store account quantity exceeds']);
            throw $ex;
          
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
