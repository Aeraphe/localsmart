<?php
namespace App\Exceptions;

class RegisterEmployeeLoginException extends BaseException
{

    protected $data = ['login_name' => 'Login Name already exists'];
}
