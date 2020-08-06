<?php
namespace App\Http\Dto;
use App\Http\Service\UserService;

class UsuarioDTO
{
    private $usuarioService;
    public function __construct()  {
    }
    public function obterUsuario($usuario,$campos=null){       
        $dto = [  
                'id'        => $usuario->id,
                'name'      => $usuario->name,
                'email '    => $usuario->email ,
                'perfil'    => $usuario->perfil
            ];        
        return $dto;
    }
    public function obterUsuarioTemplate($usuario,$template=null){

        $dto = array();
        isset($template['usuario.id'])      ? $dto = $dto  +   ['id'        => $usuario->id]        : true;
        isset($template['usuario.name'])    ? $dto = $dto  +   ['name'      => $usuario->name]      : true;
        isset($template['usuario.email'])   ? $dto = $dto  +   ['email'     => $usuario->email]     : true;
        isset($template['usuario.perfil'])  ? $dto = $dto  +   ['perfil'    => $usuario->perfil]    : true;
        
        return $dto;
    }
}