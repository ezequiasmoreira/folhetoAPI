<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Validator;
use App\Http\Service\EmpresaService;
use App\Enums\Perfil;
use App\Http\Service\FuncionarioService;
use App\Http\Service\UserService;

class UserSpec
{
    private $empresaService;
    private $usuarioService;
    private $funcionarioService;
    public function __construct()  {
    }
    
    public function validarUsuario($usuario){
        if(!$usuario){
            ApiException::lancarExcessao(5,'Usuário'); 
        }        
    }
    public function validarPermissaoPorPerfil($usuario,$usuarioLogado){        
        $perfilUsuario = Perfil::getValue('Usuario');           
        if ($usuarioLogado->perfil == $perfilUsuario) {
           $this->validarPerfilUsuario($usuario,$usuarioLogado);
        }else{
            $this->validarPerfilFuncionario($usuario,$usuarioLogado);
            $this->validarVinculoFuncionario($usuario,$usuarioLogado);
        } 
        return true;
    }
    public function validarPerfilUsuario($usuario,$usuarioLogado){
        if($usuario->id != $usuarioLogado->id){
            ApiException::lancarExcessao(7,'('.$usuarioLogado->name.'),('.$usuario->name.')');
        }
    }
    
    public function usuarioLogadoPossuiEmpresa(){
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService();
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();
        $empresa = $this->empresaService->obterEmpresaPorUsuario($usuarioLogado);       
        return  ($empresa)?true:false;               
    }

    public function usuarioPossuiEmpresa($usuario){
        $this->empresaService = new EmpresaService();
        $empresa = $this->empresaService->obterEmpresaPorUsuario($usuario);
        if($empresa){
            return true;
        }
        return false;        
    }
    public function validarEmpresaVinculadaUsuarioLogado($empresa,$usuarioLogado){
        if($empresa->usuario_id != $usuarioLogado->id){
            ApiException::lancarExcessao(10,$usuarioLogado->Name.','.$empresa->razao_social);
        }
        return true;
    }
    public function validarPerfilFuncionario($usuario,$usuarioLogado){       
        $perfilFuncionario = Perfil::getValue('Funcionario');
        if (!($usuarioLogado->perfil == $perfilFuncionario)){
            ApiException::lancarExcessao(9,$usuarioLogado->perfil);
        } 
        if (!($usuario->perfil == $perfilFuncionario)){      
            ApiException::lancarExcessao(9,$usuario->perfil);
        } 
        return true;
    }
    public function permiteSalvarFuncionario($usuario){
        $this->funcionarioService = new FuncionarioService();
        $this->empresaService = new EmpresaService();
        if(!$this->ehFuncionario($usuario)){
            return false;
        }
        if(!$this->usuarioLogadoPossuiEmpresa()){
            return false;
        }
        $funcionario = $this->funcionarioService->obterFuncionarioPorUsuario($usuario,false);  
        if(!$funcionario){
            return true;
        } 
        $empresa = $this->empresaService->obterPorId($funcionario->empresa_id);
        if($empresa->usuario_id != $usuario->id){
            return false;
        }   
        return true;
    }
    private function ehFuncionario($usuario){
        $perfilFuncionario = Perfil::getValue('Funcionario');
        if (!($usuario->perfil == $perfilFuncionario)){
            return false;
        }         
        return true;
    }
    public function permitePerfilFuncionario($perfil,$permite){
        $perfilFuncionario = Perfil::getValue('Funcionario');
        if($perfil != $perfilFuncionario){
            return true;
        }
        if(!$permite){            
            ApiException::lancarExcessao(12);
        }
        return true;
    }

    public function validarPerfilPermitido($perfil,$perfisPermitido){
        $permitido = false;
        $perfis ='';
        foreach ($perfisPermitido as $perfilPermitido) { 
            $perfis =  ($perfis != '' )? $perfis.' - '.$perfilPermitido: $perfis.$perfilPermitido;
            if($perfilPermitido == $perfil){
                $permitido = true;
            }
        } 
        if(!$permitido){
            ApiException::lancarExcessao(8,$perfil.','.$perfis);
        }
        return true;      
    }
    public function validarCamposObrigatorioCadastrar($request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            ]);
            if($validator->fails()){
                ApiException::lancarExcessao(11,$validator->errors()->toJson());
            }
        return true;      
    }
    public function validarCamposObrigatorioAtualizar($request){        
        $validator = Validator::make($request->all(), [
            'id' =>  'required',
            'name' => 'required|string|max:255'
        ]);
        if($validator->fails()){
            ApiException::lancarExcessao(11,$validator->errors()->toJson());
        }
        return true;      
    }
    public function validarStatus($enviado,$esperado,$mensagemDoErro,$parametros=null){        
        if($enviado != $esperado){
            ApiException::lancarExcessao(16,$mensagemDoErro,$parametros);
        }
        return true;      
    }
}
