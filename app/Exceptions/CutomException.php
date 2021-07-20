<?php

namespace App\Exceptions;

class CutomException extends \Exception
{

    protected $data;

    public function __construct($message = "", $code = 0,array $data = null)
    {
        $this->data = $data;
        parent::__construct($message,$code,null);
    }

    public  function setData(array $data){
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }

}
