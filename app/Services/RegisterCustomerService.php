<?php

namespace App\Services;

use App\Exceptions\BaseException;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Auth;

class RegisterCustomerService
{

    /**
     * Create Custommer for the Account 
     *
     * @param [array] $data
     * 
     * @return Customer
     *
     * */
    public static function create($data)
    {

        try {

            $user = Auth::user();
            $account_id = $user->account->id;
            $data['account_id'] = $account_id;
            return Customer::create($data);

        } catch (Exception $e) {
            $exception = new BaseException('Não foi possível cadastar o cliente', $e->getCode());
            $exception->setData(['error' => $e->getMessage()]);
            throw $exception;
        }
    }
}
