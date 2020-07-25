<?php
namespace App\Http\Service;
use App\Funcionario;
use App\Http\Repository\FuncionarioRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Service\UserService;
use App\Http\Service\EmpresaService;
use App\Http\Service\EnderecoService;
use App\Http\Service\UtilService;
use App\Http\Spec\FuncionarioSpec;
//use App\Exceptions\ApiException;

class FuncionarioService
{
    private $usuarioService;
    private $empresaService;
    private $enderecoService;
    private $utilService;
    private $funcionarioRepository;
    private $funcionarioSpec;
    public function __construct()  {
        $this->funcionarioRepository = new FuncionarioRepository();
        $this->funcionarioSpec = new FuncionarioSpec();
    }
    public function validarRequisicaoSalvar($request){
        $this->funcionarioSpec->validarCamposObrigatorioSalvar($request);
        return true;
    }
    public function validarRequisicaoAtualizar($request){        
        $this->funcionarioSpec->validarCamposObrigatorioAtualizar($request);
        return true;
    }
    public function atualizar($request){
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService(); 

        $funcionario = $this->obterPorId($request->id);       
        $usuario = $this->obterUsuarioPorFuncionario($funcionario);
        $endereco = $this->obterEnderecoPorFuncionario($funcionario);
        $this->funcionarioSpec->permiteSalvar($usuario);
        $this->atualizarUsuarioVinculado($request,$usuario);        
        $this->atualizarEnderecoVinculado($request,$endereco);
        return true;
    }
    public function salvar($usuario,$empresa,$endereco){
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService();        
        $this->enderecoService = new EnderecoService();
        $this->utilService = new UtilService();

        $this->empresaService->validar($empresa); 
        $this->enderecoService->validar($endereco);       
        $this->usuarioService->validarUsuario($usuario);
        $this->funcionarioSpec->permiteSalvar($usuario);
        
        $funcionario = new Funcionario();
        $funcionario->usuario_id = $usuario->id;
        $funcionario->empresa_id = $empresa->id;
        $funcionario->endereco_id = $endereco->id;
        $salvou = $funcionario->save();
        $this->utilService->validarStatus($salvou,true,19);
        return true;
    }
    public function obterFuncionarioPorUsuario($usuario,$validaRetorno){
        $funcionario = $this->funcionarioRepository->obterFuncionarioPorUsuario($usuario,false);
        if ($validaRetorno) $this->funcionarioSpec->validar($funcionario);
        return $funcionario;
    }
    public function obterUsuarioPorFuncionario($funcionario){
        $this->usuarioService = new UserService();        
        $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);
        return $usuario;
    }
    public function obterEnderecoPorFuncionario($funcionario){
        $this->enderecoService = new EnderecoService();       
        $endereco = $this->enderecoService->obterPorId($funcionario->endereco_id);
        return $endereco;
    }
    public function obterPorId($funcionarioId){
        $funcionario = $this->funcionarioRepository->obterPorId($funcionarioId);
        $this->funcionarioSpec->validar($funcionario);
        return $funcionario;
    }
    public function atualizarUsuarioVinculado($request,$usuario){
        $this->utilService = new UtilService();
        $usuario->name      = $request->name;
        $usuario->email     = $request->email;
        $usuario->password  = Hash::make($request->password);
        $salvou = $usuario->save();
        $this->utilService->validarStatus($salvou,true,26,'usuário');
        return true;
    }
    public function atualizarEnderecoVinculado($request,$endereco){
        $this->utilService = new UtilService();
        $endereco->rua          = $request->rua;
        $endereco->numero       = $request->numero;
        $endereco->bairro       = $request->bairro;
        $endereco->complemento  = $request->complemento;
        $endereco->cep          = $request->cep;
        $endereco->cidade_id    = $request->cidade_id;
        $salvou = $endereco->save();
        $this->utilService->validarStatus($salvou,true,26,'endereco');
        return true;
    }
}
