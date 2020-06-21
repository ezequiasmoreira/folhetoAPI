<?php
namespace App\Http\Service;
use App\Http\Spec\CidadeSpec;
use App\Http\Repository\CidadeRepository;
use App\Endereco;

class CidadeService
{
    private $cidadeSpec;
    private $cidadeRepository;
    public function __construct()  {
       $this->cidadeSpec = new CidadeSpec();
       $this->cidadeRepository = new CidadeRepository();
    }
    public function obterPorId($id){
        $cidade = $this->cidadeRepository->obterPorId($id);    
        $this->cidadeSpec->validar($cidade);
        return $cidade;
    }
}
