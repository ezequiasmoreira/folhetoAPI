<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
use App\Http\Service\UserService;
use App\Http\Service\EmpresaService;
use App\Enums\Perfil;
use App\User;

class UserSpec
{
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
    public function validarVinculoFuncionario($usuario,$usuarioLogado){
        $empresaService = new EmpresaService();
        $empresa = $empresaService->obterEmpresaUsuarioLogado();
        
        
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
}
