<?php
namespace App\Http\Service;
use App\Http\Spec\EstadoSpec;
use App\Http\Repository\EstadoRepository;

class EstadoService
{
    private $estadoSpec;
    private $estadoRepository;
    public function __construct()  {
       $this->estadoSpec = new EstadoSpec();
       $this->estadoRepository = new EstadoRepository();
    }
    public function obterPorId($id){
        $estado = $this->estadoRepository->obterPorId($id);    
        $this->estadoSpec->validar($estado);
        return $estado;
    }
}
