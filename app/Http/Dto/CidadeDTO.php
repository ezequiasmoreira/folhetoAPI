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
    public function obterCidade($cidade,$campos=null){
        $this->estadoDTO = new EstadoDTO();
        
        $dto =[
            'id'        => $cidade->id,
            'nome'      => $cidade->nome,
            'codigo'    => $cidade->codigo,
            'estado'    => isset($campos['estado']) ? $this->estadoDTO->obterEstado($cidade->estado,$campos['estado']) : null,
        ];
        return $dto;
    }
    public function obterCidadeTemplate($cidade_id,$template=null){
        $this->estadoDTO = new EstadoDTO();
        $this->cidadeService = new CidadeService();
        
        $cidade =  $this->cidadeService->obterPorId($cidade_id);
        
        $dto = array();
        isset($template['cidade.id'])       ? $dto = $dto  +   ['id'    => $cidade->id]         : true;
        isset($template['cidade.nome'])     ? $dto = $dto  +   ['nome'  => $cidade->nome]       : true;
        isset($template['cidade.codigo'])   ? $dto = $dto  +   ['codigo' => $cidade->codigo]    : true;
        
        if(isset($template['cidade.estado'])){
            $estado = $this->estadoDTO->obterEstadoTemplate($cidade->estado_id,$template['cidade.estado']);
            $dto = $dto + ['estado' => $estado];
        }
        return $dto;
    }
}