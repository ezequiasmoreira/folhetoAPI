<?php

namespace App\Http\Controllers\Localizacao;
use App\Estado;
use App\Pais;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstadoController extends Controller
{
    private $estado;

    public function __construct()  {
        $this->estado = new Estado();
    }
    public function salvar(Request $request){
        $estado = Estado::create($request->all());
        return response()->json($estado,200);
    }

    public function atualizar(Request $request){
        if (!$request->id){
            return response()->json(['mensagem' =>'Não informado o estado para atualizar'],500);
        }        
        $estado = $this->getEstado($request->id);
        $estado->update($request->all());
        return response()->json($estado,200);
    }

    public function excluir($id) { 
        $this->getEstado($id)->delete();
        $retorno = [
            'mensagem' => 'excluído com sucesso'
        ];
        return response()->json($retorno,200);
    }
    public function getEstados() {
        $estados = Estado::all();
        return response()->json($estados,200);
    }
    protected function getEstado($id)  {
        return $this->estado->find($id);
    }
}
