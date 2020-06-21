<?php
namespace App\Http\Repository;
use App\Cidade;

class CidadeRepository
{
    private $cidade;
    public function __construct()  {   
       $this->cidade = new Cidade();   
    }
    public function obterPorId($id){
        return $this->cidade->find($id);
    }
   
}
