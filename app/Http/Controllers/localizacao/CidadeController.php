<?php

namespace App\Http\Controllers\Localizacao;
use App\Estado;
use App\Cidade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\TryCatch;

class CidadeController extends Controller
{
    private $cidade;

    public function __construct()  {
        $this->cidade = new Cidade();
    }

   public function salvar(Request $request){
        $cidade = Cidade::create($request->all());
        return response()->json($cidade,200);
    }
    public function atualizar(Request $request){
        if (!$request->id){
            return response()->json(['mensagem' =>'Não informado a cidade para atualizar'],500);
        }
        $cidade = $this->getCidade($request->id);
        $cidade->update($request->all());
        return response()->json($cidade,200);
    }
    public function excluir($id) {
        $this->getCidade($id)->delete();
        return response()->json(['mensagem' => 'excluído com sucesso'],200);
    }
    
    public function getCidadePorEstado($estado_id)  {
        return response()->json(\App\Cidade::where('estado_id',$estado_id)->get(['id', 'nome', 'codigo']),200);
    }
    public function getCidade($id)  {
        return $this->cidade->find($id);
    }
}
