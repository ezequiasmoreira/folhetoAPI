<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
class CidadeSpec
{
    public function __construct()  {
    }
    public function validar($cidade){ 
        $this->existeCidade($cidade);
        return true;    
    }
    private function existeCidade($cidade){ 
        if(!$cidade){
            ApiException::lancarExcessao(5,'Cidade');
        }
        return true;    
    }
}
