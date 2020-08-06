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
        $funcionarios = $empresa->funcionarios;
        foreach ($funcionarios as $funcionario) {
            $usuario = $funcionario->usuario;
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
    public function obterFuncionario($funcionario,$campos=null){
        $this->empresaDTO = new EmpresaDTO();
        $this->enderecoDTO = new EnderecoDTO();

        $usuario = $funcionario->usuario;
        $dto =[
            'id'        => $funcionario->id,
            'name'      => $usuario->name,
            'email'     => $usuario->email,
            'endereco'  => isset($campos['endereco']) ? $this->enderecoDTO->obterEndereco($funcionario->endereco,$campos['endereco']) : null,
            'empresa'   => isset($campos['empresa']) ? $this->empresaDTO->obterEmpresa($funcionario->empresa,$campos['empresa']) : null,
        ];
        return $dto;
    }

    public function obterFuncionarioTemplate($funcionario,$template=null){
        $this->empresaDTO = new EmpresaDTO();
        $this->enderecoDTO = new EnderecoDTO();

        $usuario = $funcionario->usuario;
        $dto = array();

        isset($template['funcionario.id'])          ? $dto = $dto  +   ['id'    => $funcionario->id]    : true;
        isset($template['funcionario.name'])        ? $dto = $dto  +   ['name'  => $usuario->name]      : true;
        isset($template['funcionario.email'])       ? $dto = $dto  +   ['email' => $usuario->email]     : true;
        
        if(isset($template['funcionario.endereco'])){
            $endereco = $this->enderecoDTO->obterEnderecoTemplate($funcionario->endereco,$template['funcionario.endereco']);
            $dto = $dto + ['endereco' => $endereco];
        }
        if(isset($template['funcionario.empresa'])){
            $empresa = $this->empresaDTO->obterEmpresaTemplate($funcionario->empresa,$template['funcionario.empresa']);
            $dto = $dto + ['empresa' => $empresa];
        }
        return $dto;
    }
    public function obterFuncionariosTemplate($empresa,$template=null){
        $this->empresaDTO = new EmpresaDTO();
        $this->enderecoDTO = new EnderecoDTO();    
        
        $lista  = array();        
        $funcionarios = $empresa->funcionarios;

        foreach ($funcionarios as $funcionario) {
            $dto = array();
            $usuario = $funcionario->usuario;

            isset($template['funcionario.id'])          ? $dto = $dto  +   ['id'    => $funcionario->id]    : true;
            isset($template['funcionario.name'])        ? $dto = $dto  +   ['name'  => $usuario->name]      : true;
            isset($template['funcionario.email'])       ? $dto = $dto  +   ['email' => $usuario->email]     : true;
            
            if(isset($template['funcionario.endereco'])){
                $endereco = $this->enderecoDTO->obterEnderecoTemplate($funcionario->endereco,$template['funcionario.endereco']);
                $dto = $dto + ['endereco' => $endereco];
            }

            if(isset($template['funcionario.empresa'])){
                $empresa = $this->empresaDTO->obterEmpresaTemplate($funcionario->empresa,$template['funcionario.empresa']);
                $dto = $dto + ['empresa' => $empresa];
            }            
            array_push($lista, $dto);
        }
        return $lista;
    }
}
