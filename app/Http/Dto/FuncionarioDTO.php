<?php
namespace App\Http\Dto;
use App\Funcionario;
use App\Http\Repository\FuncionarioRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Service\UserService;
use App\Http\Service\EmpresaService;
use App\Http\Service\EnderecoService;
use App\Http\Service\UtilService;
use App\Http\Spec\FuncionarioSpec;
use App\Exceptions\ApiException;

class FuncionarioDTO
{
    private $usuarioService;
    private $enderecoService;
    private $funcionarioRepository;
    public function __construct()  {
        $this->funcionarioRepository = new FuncionarioRepository();
    }
    public function obterFuncionarios($empresa){
        $this->usuarioService = new UserService();
        $this->enderecoService = new EnderecoService();
        $this->empresaService = new EmpresaService();

        $lista = array();
        $funcionarios = $this->funcionarioRepository->obterFuncionarios($empresa);
        foreach ($funcionarios as $funcionario) {
            $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);
            $dto =[
                'name'   => $usuario->name,
                'email'     => $usuario->email,
                'endereco'  => $this->enderecoService->obterPorId($funcionario->endereco_id),
                'empresa'  => $this->enderecoService->obterPorId($funcionario->endereco_id),
            ];
            array_push($lista, $dto);
        }
        return $lista;
    }
}