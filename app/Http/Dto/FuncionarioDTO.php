<?php
namespace App\Http\Dto;
use App\Http\Repository\FuncionarioRepository;
use App\Http\Service\FuncionarioService;
use App\Http\Service\UserService;
use App\Http\Dto\EmpresaDTO;
use App\Http\Dto\EnderecoDTO;

class FuncionarioDTO
{
    private $usuarioService;
    private $enderecoDTO;
    private $empresaDTO;
    private $funcionarioService;
    private $funcionarioRepository;
    public function __construct()  {
        $this->funcionarioRepository = new FuncionarioRepository();
    }
    public function obterFuncionarios($empresa,$campos=null){
        $this->empresaDTO = new EmpresaDTO();
        $this->enderecoDTO = new EnderecoDTO();
        $this->usuarioService = new UserService();    
        
        $lista = array();
        $funcionarios = $this->funcionarioRepository->obterFuncionarios($empresa);
        foreach ($funcionarios as $funcionario) {
            $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);
            $dto =[
                'id'        => $funcionario->id,
                'name'      => $usuario->name,
                'email'     => $usuario->email,
                'endereco'  => isset($campos['endereco']) ? $this->enderecoDTO->obterEndereco($funcionario->endereco_id,$campos['endereco']) : null,
                'empresa'   => isset($campos['empresa']) ? $this->empresaDTO->obterEmpresa($funcionario->empresa_id,$campos['empresa']) : null,
            ];
            array_push($lista, $dto);
        }
        return $lista;
    }
    public function obterFuncionario($funcionario_id,$campos=null){
        $this->empresaDTO = new EmpresaDTO();
        $this->enderecoDTO = new EnderecoDTO();
        $this->usuarioService = new UserService();
        $this->funcionarioService = new FuncionarioService();

        $funcionario =  $this->funcionarioService->obterPorId($funcionario_id);
        $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);
        $dto =[
            'id'        => $funcionario->id,
            'name'      => $usuario->name,
            'email'     => $usuario->email,
            'endereco'  => isset($campos['endereco']) ? $this->enderecoDTO->obterEndereco($funcionario->endereco_id,$campos['endereco']) : null,
            'empresa'   => isset($campos['empresa']) ? $this->empresaDTO->obterEmpresa($funcionario->empresa_id,$campos['empresa']) : null,
        ];
        return $dto;
    }

    public function obterFuncionarioTemplate($funcionario_id,$template=null){
        $this->empresaDTO = new EmpresaDTO();
        $this->enderecoDTO = new EnderecoDTO();
        $this->usuarioService = new UserService();
        $this->funcionarioService = new FuncionarioService();

        $funcionario =  $this->funcionarioService->obterPorId($funcionario_id);
        $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);

        $dto = array();
        isset($template['funcionario.id'])          ? $dto = $dto  +   ['id'    => $funcionario->id]    : true;
        isset($template['funcionario.name'])        ? $dto = $dto  +   ['name'  => $usuario->name]      : true;
        isset($template['funcionario.email'])       ? $dto = $dto  +   ['email' => $usuario->email]     : true;
        
        if(isset($template['funcionario.endereco'])){
            $endereco = $this->enderecoDTO->obterEnderecoTemplate($funcionario->endereco_id,$template['funcionario.endereco']);
            $dto = $dto + ['endereco' => $endereco];
        }
        if(isset($template['funcionario.empresa'])){
            $empresa = $this->empresaDTO->obterEmpresaTemplate($funcionario->empresa_id,$template['funcionario.empresa']);
            $dto = $dto + ['empresa' => $empresa];
        }
        return $dto;
    }
    public function obterFuncionariosTemplate($empresa,$template=null){
        $this->empresaDTO = new EmpresaDTO();
        $this->enderecoDTO = new EnderecoDTO();
        $this->usuarioService = new UserService();    
        
        $lista  = array();        
        $funcionarios = $this->funcionarioRepository->obterFuncionarios($empresa);

        foreach ($funcionarios as $funcionario) {
            $dto = array();
            $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);
            isset($template['funcionario.id'])          ? $dto = $dto  +   ['id'    => $funcionario->id]    : true;
            isset($template['funcionario.name'])        ? $dto = $dto  +   ['name'  => $usuario->name]      : true;
            isset($template['funcionario.email'])       ? $dto = $dto  +   ['email' => $usuario->email]     : true;
            
            if(isset($template['funcionario.endereco'])){
                $endereco = $this->enderecoDTO->obterEnderecoTemplate($funcionario->endereco_id,$template['funcionario.endereco']);
                $dto = $dto + ['endereco' => $endereco];
            }

            if(isset($template['funcionario.empresa'])){
                $empresa = $this->empresaDTO->obterEmpresaTemplate($funcionario->empresa_id,$template['funcionario.empresa']);
                $dto = $dto + ['empresa' => $empresa];
            }            
            array_push($lista, $dto);
        }
        return $lista;
    }
}
