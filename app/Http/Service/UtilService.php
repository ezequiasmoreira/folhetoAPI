<?php
namespace App\Http\Service;
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
    public function validarStatus($enviado,$esperado,$mensagemDoErro){ 
        $this->utilSpec->validarStatus($enviado,$esperado,$mensagemDoErro);
        return true;      
    }
    
}
    

