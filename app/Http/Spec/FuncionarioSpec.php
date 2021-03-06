<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
use App\Funcionario;
use App\Http\Service\FuncionarioService;
use App\Http\Service\UserService;
use Illuminate\Support\Facades\Validator;

class FuncionarioSpec
{
    private $usuarioService;
    private $funcionarioService;
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

    public function permiteExcluirFuncionario(Funcionario $funcionario,string $origem)
    { 
        $this->usuarioService = new UserService();
        
        if ($this->ehProprietario($funcionario) && $origem !="Empresa") 
        {
            ApiException::throwException(31);
        }

        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();

        if (!$this->ehProprietario($usuarioLogado->funcionario)) 
        {
            ApiException::throwException(30);
        }
        return true;    
    }
    public function ehProprietario($funcionario){ 
        $this->funcionarioService = new FuncionarioService();
        $proprietario = $this->funcionarioService->obterFuncionarioProprietario($funcionario);
        return ($funcionario->id == $proprietario->id) ? true : false;
    }
    public function permiteRetornarFuncionario($funcionarioProprietario,$funcionarioARetornar){
        if(!$funcionarioARetornar){
            return false;
        } 
        return ($funcionarioProprietario->empresa_id == $funcionarioARetornar->empresa_id);
    }
    public function validarCamposObrigatorioSalvar($request){ 
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
            ApiException::throwException(11,$validator->errors()->toJson());
        }
        return true;    
    }
    public function validarCamposObrigatorioAtualizar($request){         
        $this->funcionarioService = new FuncionarioService();        
        (!$request->id)     ? ApiException::throwException(25)          : true;
        (!$request->email)  ? ApiException::throwException(14,'E-mail') : true;        
        $funcionario = $this->funcionarioService->obterPorId($request->id);       
        $usuario = $funcionario->usuario;       
        (Boolean)$emailUnico = ($usuario->email != $request->email);
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'.($emailUnico ? '|unique:users':''),
            'password' => 'required|string|min:6|confirmed',
            'rua' => 'required|string|max:255',
            'numero' => 'required|integer',
            'bairro'  => 'required|string|max:255',
            'complemento'  => 'required|string|max:255',
            'cep'  => 'required|string|max:10',
            'cidade_id'  => 'required|integer',            
        ]);
        if($validator->fails()){
            ApiException::throwException(11,$validator->errors()->toJson());
        }
        return true;    
    }
    private function possuiPermissaoParaSalvarFuncionario($usuario){ 
        $this->usuarioService = new UserService();
        if(!$this->usuarioService->permiteSalvarFuncionario($usuario)){
            ApiException::throwException(17);
        }
        return true;    
    }
    private function existeFuncionario($funcionario){ 
        if(!$funcionario){
            ApiException::throwException(5,'Funcionario');
        }
        return true;    
    }
}
