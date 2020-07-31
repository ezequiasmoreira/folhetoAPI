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
    public function obterEstadoTemplate($estado_id,$template=null){
        $this->paisDTO = new PaisDTO();
        $this->estadoService = new EstadoService();
        $estado =  $this->estadoService->obterPorId($estado_id);
       
        $dto = array();
        isset($template['estado.id'])       ? $dto = $dto  +   ['id'    => $estado->id]         : true;
        isset($template['estado.nome'])     ? $dto = $dto  +   ['nome'  => $estado->nome]       : true;
        isset($template['estado.codigo'])   ? $dto = $dto  +   ['codigo' => $estado->codigo]    : true;
        isset($template['estado.sigla'])   ? $dto = $dto  +   ['sigla' => $estado->sigla]    : true;
        
        if(isset($template['estado.pais'])){
            $pais = $this->paisDTO->obterPaisTemplate($estado->pais_id,$template['estado.pais']);
            $dto = $dto + ['pais' => $pais];
        }
        return $dto;
    }
}