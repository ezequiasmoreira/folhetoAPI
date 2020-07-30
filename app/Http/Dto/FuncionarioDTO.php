<?php
namespace App\Http\Dto;
use App\Funcionario;
use App\Http\Repository\FuncionarioRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Service\UserService;
use App\Http\Service\EmpresaService;
use App\Http\Dto\EnderecoDTO;
use App\Http\Spec\FuncionarioSpec;
use App\Exceptions\ApiException;

class FuncionarioDTO
{
    private $usuarioService;
    private $enderecoService;
    private $enderecoDTO;
    private $funcionarioRepository;
    public function __construct()  {
        $this->funcionarioRepository = new FuncionarioRepository();
    }
    public function obterFuncionarios($empresa,$campos=null){
        $this->usuarioService = new UserService();        
        $this->empresaService = new EmpresaService();
        $this->enderecoDTO = new EnderecoDTO();

        $lista = array();
        $funcionarios = $this->funcionarioRepository->obterFuncionarios($empresa);
        foreach ($funcionarios as $funcionario) {
            $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);
            $dto =[
                'name'      =>    $usuario->name,
                'email'     => $usuario->email,
                'endereco'  => isset($campos['endereco']) ? $this->enderecoDTO->obterEndereco($funcionario->endereco_id,$campos['endereco']) : null,
                'empresa'   => isset($campos['empresa']) ? $this->empresaService->obterPorId($funcionario->empresa_id,$campos['empresa']) : null,
            ];
            array_push($lista, $dto);
        }
        return $lista;
    }
}