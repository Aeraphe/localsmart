<?php

namespace App\Exceptions\AuthenticateAccountUser;

use App\Exceptions\BaseException;

class AuthenticateEmailException extends BaseException
{

    protected $data = ['email' => 'credential not found'];

}
