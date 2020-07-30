<?php
namespace App\Http\Repository;
use App\Estado;

class EstadoRepository
{
    private $estado;
    public function __construct()  {   
       $this->estado = new Estado();   
    }
    public function obterPorId($id){
        return $this->estado->find($id);
    }
   
}
