<?php

namespace App\Http\Controllers\Localizacao;
use App\Estado;
use App\Cidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CidadeController extends Controller
{
    private $cidade;

    public function __construct()  {
        $this->cidade = new Cidade();
    }

   public function salvar(Request $request){
        $cidade = Cidade::create($request->all());
        return response()->json($cidade);
    }
    public function atualizar(Request $request){
        $cidade = $this->getCidade($request->id);
        $cidade->update($request->all());
        return response()->json($cidade,200);
    }
    public function excluir($id) {
        $this->getCidade($id)->delete();
        $retorno = [
            'mensagem' => 'excluído com sucesso'
        ];
        return response()->json($retorno,200);
    }
    
    public function getCidadePorEstado($estado_id)  {
        return response()->json(\App\Cidade::where('estado_id',$estado_id),200);
    }
    public function getCidade($id)  {
        return $this->cidade->find($id);
    }
}
