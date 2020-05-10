<?php

namespace App\Http\Controllers\Localizacao;
use App\Pais;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class PaisController extends Controller
{
    private $pais;

    public function __construct()  {
        $this->pais = new Pais();
    }

    public function salvar(Request $request){
        $pais = Pais::create($request->all());
        return response()->json($pais,200);
    }

    public function atualizar(Request $request){
        $pais = $this->pais->find($request->id);
        $pais->update($request->all());
        return response()->json($pais,200);
    }

    public function excluir($id) {
        $this->getPais($id)->delete();
        $retorno = [
            'mensagem' => 'excluído com sucesso'
        ];
        return response()->json($retorno,200);
    }
    
    public function getPais($id)  {
        return response()->json($this->pais->find($id));
    }
}
