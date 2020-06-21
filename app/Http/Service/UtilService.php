<?php
namespace App\Http\Service;
use App\Exceptions\ApiException;
use App\Http\Spec\UtilSpec;
class UtilService
{
    private $utilSpec;
    public function __construct()  {
        $this->utilSpec = new UtilSpec();
    }
    public function validarCnpj($cnpj){ 
        $this->utilSpec->validarCnpj($cnpj);
        return true;      
    }
    
}
    

