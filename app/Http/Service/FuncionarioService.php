<?php
namespace App\Http\Service;
use App\Funcionario;
use App\Http\Repository\FuncionarioRepository;
use App\Http\Service\UserService;
use App\Http\Service\EmpresaService;
use App\Http\Service\EnderecoService;
use App\Http\Service\UtilService;
use App\Http\Spec\FuncionarioSpec;

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
    public function validar($endereco){
        $this->enderecoSpec->validar($endereco);
        return true;
    }
    public function obterFuncionarioPorUsuario($usuario,$validaRetorno){
        $funcionario = $this->funcionarioRepository->obterFuncionarioPorUsuario($usuario,false);
        if ($validaRetorno) $this->funcionarioSpec->validar($funcionario);
        return $funcionario;
    }
}
