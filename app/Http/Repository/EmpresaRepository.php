<?php
namespace App\Http\Repository;
use App\Empresa;

class EmpresaRepository
{
    private $empresa;
    public function __construct()  {   
       $this->empresa = new Empresa();   
    }
    public function obterEmpresaPorUsuario($usuario){
        return  Empresa::where('usuario_id',$usuario->id)->first();
    }
    public function obterPorId($id){
        return $this->empresa->find($id);
    }
   
}