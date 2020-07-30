<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
class EstadoSpec
{
    public function __construct()  {
    }
    public function validar($estado){ 
        $this->existeEstado($estado);
        return true;    
    }
    private function existeEstado($estado){ 
        if(!$estado){
            ApiException::throwException(5,'Estado');
        }
        return true;    
    }
}
