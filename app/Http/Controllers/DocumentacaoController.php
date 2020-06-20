<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*{
	"classe":"App\\Http\\Documentacao\\Enums\\Perfil",
	"metodo":"finalidade"
}*/
class DocumentacaoController extends Controller
{
    public function __construct()  {;
    }
    public function testar(Request $request){ 
        $validator = Validator::make($request->all(), [
            'classe' => 'required|string',
            'metodo' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        } 

        $classe = new $request->classe;
        $metodo = $request->metodo;

        $retorno = $classe->$metodo();
        return response()->json($retorno,201);
    }    
    
}
