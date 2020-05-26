<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
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
        $perfilFuncionario = Perfil::getValue('Funcionario');  
        if ($usuarioLogado->perfil == $perfilUsuario) {
           $this->validarPerfilUsuario($usuario,$usuarioLogado);
        }
        if ($usuarioLogado->perfil == $perfilFuncionario) {
           $this->validarPerfilFuncionario($usuario,$usuarioLogado);
        }
        return true;
    }
    public function validarPerfilUsuario($usuario,$usuarioLogado){
        if($usuario->id != $usuarioLogado->id){
            ApiException::lancarExcessao(7,'('.$usuarioLogado->name.'),('.$usuario->name.')');
        }
    }
    public function validarPerfilFuncionario($usuario,$usuarioLogado){
        
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
