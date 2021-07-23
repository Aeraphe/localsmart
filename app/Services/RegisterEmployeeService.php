<?php

namespace App\Services;

use App\Exceptions\RegisterEmployeeLoginException;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class RegisterEmployeeService
{

    /**
     * Register new employee in the Account User
     *
     * @param [array] $data
     * 
     * @return App\Models\Employee
     */
    public static function create($data)
    {

        $account_id = Auth::user()->account->id;

        $data['account_id'] = $account_id;
        //Check if there is iqual login_name on account
        $result = Employee::where([
            ['account_id', '=', $account_id],
            ['login_name', '=', $data['login_name']],
        ])->first();

        if ($result) {

            throw new RegisterEmployeeLoginException('Já existe um usuário com o mesmo login', 400);
        }

        return Employee::create($data);

    }

}
