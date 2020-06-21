<?php
namespace App\Http\Service;
use App\Funcionario;
use App\Http\Service\UserService;
use App\Http\Service\EmpresaService;
use App\Http\Service\EnderecoService;
use App\Http\Service\UtilService;

class FuncionarioService
{
    private $usuarioService;
    private $empresaService;
    private $enderecoService;
    private $utilService;
    public function __construct()  {
    }
    public function salvar($usuario,$empresa,$endereco){
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService();        
        $this->enderecoService = new EnderecoService();
        $this->utilService = new UtilService();

        $this->empresaService->validar($empresa); 
        $this->enderecoService->validar($endereco);       
        $this->usuarioService->validarUsuario($usuario);
        $this->usuarioService->validarUsuario($usuario);

        $funcionario = new Funcionario();
        $funcionario->usuario_id = $usuario->id;
        $funcionario->empresa_id = $empresa->id;
        $funcionario->endereco_id = $endereco->id;
        $salvou = $funcionario->save();
        $this->utilService->validarStatus($salvou,true,'Não foi possível salvar o funcionário');
        return true;
    }
    public function validar($endereco){
        $this->enderecoSpec->validar($endereco);
        return true;
    }
}
