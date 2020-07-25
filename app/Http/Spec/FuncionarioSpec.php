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
    public function validarCamposObrigatorio($request){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rua' => 'required|string|max:255',
            'numero' => 'required|integer',
            'bairro'  => 'required|string|max:255',
            'complemento'  => 'required|string|max:255',
            'cep'  => 'required|string|max:10',
            'cidade_id'  => 'required|integer',            
        ]);
        if($validator->fails()){
            ApiException::lancarExcessao(11,$validator->errors()->toJson());
        }
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
