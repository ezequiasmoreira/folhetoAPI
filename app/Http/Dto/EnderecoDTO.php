<?php
namespace App\Http\Dto;
use App\Http\Dto\CidadeDTO;
use App\Http\Service\EnderecoService;
use App\Http\Repository\EnderecoRepository;

class EnderecoDTO
{
    private $cidadeDTO;
    private $enderecoService;
    private $enderecoRepository;
    public function __construct()  {
        $this->enderecoRepository = new EnderecoRepository();
    }
    public function obterEndereco($endereco,$campos=null){
        $this->cidadeDTO = new CidadeDTO();
        
        $dto =[
            'id'            => $endereco->id,
            'rua'           => $endereco->rua,
            'numero'        => $endereco->numero,
            'bairro'        => $endereco->bairro,
            'complemento'   => $endereco->complemento,
            'cep'           => $endereco->cep, 
            'cidade'        => isset($campos['cidade']) ? $this->cidadeDTO->obterCidade($endereco->cidade,$campos['cidade']) : null,
        ];
        return $dto;
    }
    public function obterEnderecoTemplate($endereco_id,$template=null){
        $this->cidadeDTO = new CidadeDTO();
        $this->enderecoService = new EnderecoService();
        
        $endereco =  $this->enderecoService->obterPorId($endereco_id);

        $dto = array();
        isset($template['endereco.id'])             ? $dto = $dto  +   ['id'    => $endereco->id]                   : true;
        isset($template['endereco.rua'])            ? $dto = $dto  +   ['rua'  => $endereco->rua]                   : true;
        isset($template['endereco.numero'])         ? $dto = $dto  +   ['numero' => $endereco->numero]              : true;
        isset($template['endereco.bairro'])         ? $dto = $dto  +   ['bairro'    => $endereco->bairro]           : true;
        isset($template['endereco.complemento'])    ? $dto = $dto  +   ['complemento'  => $endereco->complemento]   : true;
        isset($template['endereco.cep'])            ? $dto = $dto  +   ['cep' => $endereco->cep]                    : true;
        
        if(isset($template['endereco.cidade'])){
            $cidade = $this->cidadeDTO->obterCidadeTemplate($endereco->cidade_id,$template['endereco.cidade']);
            $dto = $dto + ['cidade' => $cidade];
        }
         return $dto;
    }
}