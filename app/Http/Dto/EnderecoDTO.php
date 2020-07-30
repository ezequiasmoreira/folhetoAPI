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
    public function obterEndereco($endereco_id,$campos=null){
        $this->cidadeDTO = new CidadeDTO();
        $this->enderecoService = new EnderecoService();
        
        $endereco =  $this->enderecoService->obterPorId($endereco_id);
        $dto =[
            'id'            => $endereco->id,
            'rua'           => $endereco->rua,
            'numero'        => $endereco->numero,
            'bairro'        => $endereco->bairro,
            'complemento'   => $endereco->complemento,
            'cep'           => $endereco->cep, 
            'cidade'        => isset($campos['cidade']) ? $this->cidadeDTO->obterCidade($endereco->cidade_id,$campos['cidade']) : null,
        ];
        return $dto;
    }
}