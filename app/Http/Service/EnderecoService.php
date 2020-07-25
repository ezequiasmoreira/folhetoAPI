<?php
namespace App\Http\Service;
use App\Endereco;
use App\Http\Spec\EnderecoSpec;
use App\Http\Service\CidadeService;
use App\Http\Repository\EnderecoRepository;

class EnderecoService
{
    private $enderecoSpec;
    private $enderecoRepository;
    private $cidadeService;
    public function __construct()  {  
        $this->enderecoSpec = new EnderecoSpec();
        $this->enderecoRepository = new EnderecoRepository();
    }
    public function salvar($request){
        $this->cidadeService = new CidadeService();

        $this->enderecoSpec->validarCamposObrigatorioSalvar($request);
        $cidade = $this->cidadeService->obterPorId($request->cidade_id);
        $endereco = new Endereco();
        $endereco->rua = $request->rua;
        $endereco->numero = $request->numero;
        $endereco->bairro = $request->bairro;
        $endereco->complemento = $request->complemento;
        $endereco->cep = $request->cep;
        $endereco->cidade_id = $cidade->id;
        $endereco->save();
        return $endereco;
    }
    public function validar($endereco){        
        $this->enderecoSpec->validar($endereco);
        return true;
    }
    public function obterPorId($enderecoId){
        $endereco = $this->enderecoRepository->obterPorId($enderecoId);
        $this->enderecoSpec->validar($endereco);
        return $endereco;
    }
}
