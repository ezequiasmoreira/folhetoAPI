<?php

namespace App\Http\Controllers\Localizacao;
use Illuminate\Support\Facades\DB;
use App\Endereco;
use App\Cidade;
use App\Estado;
use App\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnderecoController extends Controller
{
    private $endereco;

    public function __construct()  {
        $this->endereco = new Endereco();
    }
    
    public function salvar(Request $request){
        $endereco = Endereco::create($request->all());
        return response()->json($endereco,200);
    }
    
    public function atualizar(Request $request){
        if (!$request->id){
            return response()->json(['mensagem' =>'Não informado o endereço para atualizar'],500);
        }
        $endereco = $this->getEndereco($request->id);
        $endereco->update($request->all());
        return response()->json($endereco,200);
    }
    public function excluir($id) {
        $this->getEndereco($id)->delete();
        return response()->json(['mensagem' => 'excluído com sucesso'],200);
    }
    public function getEndereco($id)  {
        return $this->endereco->find($id);
    }
}
