<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
use App\User;

class UserSpec
{
    public function __construct()  {
    }
    
    public function validarUsuario($usuario){
        if(!$usuario){
            ApiException::lancarExcessao(5); 
        }        
    }
}
