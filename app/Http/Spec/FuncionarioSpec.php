<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
use App\Http\Service\UserService;

class FuncionarioSpec
{
    private $usuarioService;
    public function __construct()  {
    }
    public function validar($funcionario){ 
        $this->existeFuncionario($funcionario);
        return true;    
    }
    public function permiteSalvar($usuario){ 
        $this->possuiPermissaoParaSalvarFuncionario($usuario);
        return true;    
    }
    private function possuiPermissaoParaSalvarFuncionario($usuario){ 
        $this->usuarioService = new UserService();
        if(!$this->usuarioService->permiteSalvarFuncionario($usuario)){
            ApiException::lancarExcessao(17);
        }
        return true;    
    }
    private function existeFuncionario($funcionario){ 
        if(!$funcionario){
            ApiException::lancarExcessao(5,'Funcionario');
        }
        return true;    
    }
}
