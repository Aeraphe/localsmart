<?php

namespace App\Exceptions\AuthenticateAccountUser;

use App\Exceptions\BaseException;

class AuthenticatePasswordException extends BaseException
{

    protected $data = ['password' => 'password does not match'];


}
