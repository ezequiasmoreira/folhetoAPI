<?php

namespace App\Http\Service;
use App\Http\Repository\UserRepository;
use App\Enums\Perfil;
use App\Http\Spec\UserSpec;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserService
{
    private $user;
    private $userRepository;
    public $userSpec;

    public function __construct()  {
        $this->userSpec = new UserSpec();
        $this->userRepository = new UserRepository();
    }
    public function obterUsuarioLogado(){
        $usuario = Auth::user();
        return $usuario;
    }
    public function obterPorId($id){        
        return $this->userRepository->obterPorId($id);
    }
    public function validarUsuario($usuario){        
        return $this->userSpec->validarUsuario($usuario);
    }
    public function atualizar($request){   
        $usuario = $this->obterPorId($request->id);
        $usuarioLogado = $this->obterUsuarioLogado();  
        $this->usuarioPermiteAlterar($usuario,$usuarioLogado);
        $usuario->name = $request->name;
        $usuario->save();  
        return true;
    }
    public function usuarioPermiteAlterar($usuario,$usuarioLogado){        
        $perfisPermitido = $this->obterPerfisPermitido(); 
        $this->userSpec->validarPerfilPermitido($usuarioLogado->perfil,$perfisPermitido);
        $this->userSpec->validarPermissaoPorPerfil($usuario,$usuarioLogado);
        return true;
    }
    public function obterPerfisPermitido(){
       return Perfil::getValues();
    }
}
