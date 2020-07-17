<?php
namespace App\Http\Repository;
use App\Funcionario;

class FuncionarioRepository
{
    private $funcionario;
    public function __construct()  {   
       $this->funcionario = new Funcionario();   
    }
    public function obterFuncionarioPorUsuario($usuario){
        return  Funcionario::where('usuario_id',$usuario->id)->first();
    }
   
}