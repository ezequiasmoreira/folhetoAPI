<?php

namespace App\Http\Service;
use App\Http\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Enums\Perfil;
use App\Http\Spec\UserSpec;
use App\Http\Service\EmpresaService;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Exceptions\ApiException;

class UserService
{
    private $empresaService;
    private $userRepository;
    public $userSpec;
    public function __construct()  {
       $this->userSpec = new UserSpec();
       $this->userRepository = new UserRepository();
    }
    public function obterUsuarioLogado(){
        $usuario = Auth::user();
        $this->userSpec->validarUsuario($usuario);
        return $usuario;
    }
    public function obterPorId($id){ 
        $usuario = $this->userRepository->obterPorId($id); 
        $this->userSpec->validarUsuario($usuario);      
        return $usuario;
    }
    public function validarUsuario($usuario){        
        return $this->userSpec->validarUsuario($usuario);
    }
    public function permiteSalvarFuncionario($usuario){        
        return $this->userSpec->permiteSalvarFuncionario($usuario);
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
    public function atualizarPerfilFuncionario($empresa,$usuario){
        $this->empresaService = new EmpresaService();
        $this->empresaService->validar($empresa);
        $this->validarUsuario($usuario);
        $this->validarEmpresaVinculadaUsuarioLogado($empresa,$usuario);
        $perfilFuncionario = Perfil::getValue('Funcionario');
        $usuario->perfil = $perfilFuncionario;
        $salvou = $usuario->save();
        $this->userSpec->validarStatus($salvou,true,21);
        return true;
    }
    public function validarEmpresaVinculadaUsuarioLogado($empresa,$usuario){
        $this->userSpec->validarEmpresaVinculadaUsuarioLogado($empresa,$usuario);
        return true;
    }
    public function usuarioLogadoPossuiEmpresa(){
        return $this->userSpec->usuarioLogadoPossuiEmpresa();
    }
     
}
