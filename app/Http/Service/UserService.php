<?php

namespace App\Http\Service;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
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
    public function salvar($request){
        if ($request->get('perfil')){
            $perfisPermitido = $this->obterPerfisPermitido(); 
            $this->userSpec->validarPerfilPermitido($request->get('perfil'),$perfisPermitido); 
            $this->userSpec->permitePerfilFuncionario($request->get('perfil'),false);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'perfil' => $request->get('perfil') ? $request->get('perfil') : 'USUARIO',
        ]);
        return $user;
    }
    public function validarCamposObrigatorioCadastrar($request){
        $this->userSpec->validarCamposObrigatorioCadastrar($request); 
        return true;
    }
    public function validarCamposObrigatorioAtualizar($request){
        $this->userSpec->validarCamposObrigatorioAtualizar($request); 
        return true;
    }
}
