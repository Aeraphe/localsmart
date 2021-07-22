<?php

namespace App\Exceptions;

class BaseException extends \Exception
{

    protected $data;


    public  function setData(array $data){
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }

}
