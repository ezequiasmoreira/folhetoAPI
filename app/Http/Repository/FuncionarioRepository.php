<?php
namespace App\Http\Repository;
use App\Funcionario;

class FuncionarioRepository
{
    private $funcionario;
    public function __construct()  {   
       $this->funcionario = new Funcionario();   
    }
    public function obterFuncionarioPorEndereco($endereco){
        return  Funcionario::where('endereco_id',$endereco->id)->first();
    }
    public function obterFuncionarioPorUsuario($usuario){
        return  Funcionario::where('usuario_id',$usuario->id)->first();
    }
    public function obterFuncionarios($empresa){
        return  Funcionario::where('empresa_id',$empresa->id)->get();
    }
    public function obterPorId($funcionarioId){
        return  Funcionario::where('id',$funcionarioId)->first();
    }
   
}