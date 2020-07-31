<?php
namespace App\Http\Dto;
use App\Http\Repository\FuncionarioRepository;
use App\Http\Service\UserService;
use App\Http\Dto\EmpresaDTO;
use App\Http\Dto\EnderecoDTO;

class FuncionarioDTO
{
    private $usuarioService;
    private $enderecoDTO;
    private $empresaDTO;
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
                'name'      =>    $usuario->name,
                'email'     => $usuario->email,
                'endereco'  => isset($campos['endereco']) ? $this->enderecoDTO->obterEndereco($funcionario->endereco_id,$campos['endereco']) : null,
                'empresa'   => isset($campos['empresa']) ? $this->empresaDTO->obterEmpresa($funcionario->empresa_id,$campos['empresa']) : null,
            ];
            array_push($lista, $dto);
        }
        return $lista;
    }
}