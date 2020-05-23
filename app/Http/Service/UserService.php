<?php

namespace App\Http\Service;
use App\Http\Repository\UserRepository;
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
}
