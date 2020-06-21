<?php
namespace App\Http\Service;
use App\Http\Spec\EnderecoSpec;
use App\Http\Service\CidadeService;
use App\Endereco;

class EnderecoService
{
    private $enderecoSpec;
    private $cidadeService;
    public function __construct()  {
        $this->enderecoSpec = new EnderecoSpec();
        $this->cidadeService = new CidadeService();
    }
    public function salvar($request){
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
}
