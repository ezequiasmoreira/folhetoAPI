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
    public function obterEstado($estado,$campos=null){
        $this->paisDTO = new PaisDTO();

        $dto =[
            'id'        => $estado->id,
            'nome'      => $estado->nome,
            'codigo'    => $estado->codigo,
            'sigla'     => $estado->sigla,
            'pais'      => isset($campos['pais']) ? $this->paisDTO->obterPais($estado->pais) : null,
        ];
        return $dto;
    }
    public function obterEstadoTemplate($estado,$template=null){
        $this->paisDTO = new PaisDTO();
       
        $dto = array();
        isset($template['estado.id'])       ? $dto = $dto  +   ['id'    => $estado->id]         : true;
        isset($template['estado.nome'])     ? $dto = $dto  +   ['nome'  => $estado->nome]       : true;
        isset($template['estado.codigo'])   ? $dto = $dto  +   ['codigo' => $estado->codigo]    : true;
        isset($template['estado.sigla'])   ? $dto = $dto  +   ['sigla' => $estado->sigla]    : true;
        
        if(isset($template['estado.pais'])){
            $pais = $this->paisDTO->obterPaisTemplate($estado->pais,$template['estado.pais']);
            $dto = $dto + ['pais' => $pais];
        }
        return $dto;
    }
}