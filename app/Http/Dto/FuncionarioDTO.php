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
    private $funcionarioRepository;
    public function __construct()  {
        $this->funcionarioRepository = new FuncionarioRepository();
    }
    public function obterFuncionarios($empresa){
        $funcionarios = $this->funcionarioRepository->obterFuncionarios($empresa);
        return $funcionarios;
    }
}