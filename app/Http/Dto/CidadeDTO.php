<?php
namespace App\Http\Dto;
use App\Http\Dto\EstadoDTO;
use App\Http\Service\CidadeService;
use App\Http\Repository\CidadeRepository;

class CidadeDTO
{
    private $estadoDTO;
    private $cidadeService;
    private $cidadeRepository;
    public function __construct()  {
        $this->cidadeRepository = new CidadeRepository();
    }
    public function obterCidade($cidade_id,$campos=null){
        $this->estadoDTO = new EstadoDTO();
        $this->cidadeService = new CidadeService();
        $cidade =  $this->cidadeService->obterPorId($cidade_id);
        $dto =[
            'id'        => $cidade->id,
            'nome'      => $cidade->nome,
            'codigo'    => $cidade->codigo,
            'estado'    => isset($campos['estado']) ? $this->estadoDTO->obterEstado($cidade->estado_id,$campos['estado']) : null,
        ];
        return $dto;
    }
}