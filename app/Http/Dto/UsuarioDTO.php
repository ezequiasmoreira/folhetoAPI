<?php
namespace App\Http\Dto;
use App\Http\Service\UserService;

class UsuarioDTO
{
    private $usuarioService;
    public function __construct()  {
    }
    public function obterEmpresa($usuario_id,$campos=null){       
        $this->usuarioService = new UserService();
        $usuario = $this->usuarioService->obterPorId($usuario_id);
        $dto = [  
                'id'        => $usuario->id,
                'name'      => $usuario->name,
                'email '    => $usuario->email ,
                'perfil'    => $usuario->perfil
            ];        
        return $dto;
    }
}