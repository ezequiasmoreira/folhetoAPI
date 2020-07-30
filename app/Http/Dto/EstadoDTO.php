<?php
namespace App\Http\Dto;
use App\Http\Dto\PaisDTO;
use App\Http\Service\EstadoService;
use App\Http\Repository\EstadoRepository;

class EstadoDTO
{
    private $paisDTO;
    private $estadoService;
    private $estadoRepository;
    public function __construct()  {
        $this->estadoRepository = new EstadoRepository();
    }
    public function obterEstado($estado_id,$campos=null){
        $this->paisDTO = new PaisDTO();
        $this->estadoService = new EstadoService();
        $estado =  $this->estadoService->obterPorId($estado_id);
        $dto =[
            'id'        => $estado->id,
            'nome'      => $estado->nome,
            'codigo'    => $estado->codigo,
            'sigla'     => $estado->codigo,
            'pais'      => isset($campos['pais']) ? $this->paisDTO->obterPais($estado->pais_id) : null,
        ];
        return $dto;
    }
}