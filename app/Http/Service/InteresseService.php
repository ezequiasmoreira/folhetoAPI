<?php

namespace App\Http\Service;
use App\Exceptions\ApiException;
use App\Enums\TipoInteresse;
use App\Interesse;
use App\User;

class InteresseService
{
    public function __construct()  {
        $this->interrese = new Interesse();
    }
    public function salvar (User $usuario){
        
        $interesse = Interesse::where('usuario_id',$usuario->id)->first();
        if($interesse){
            ApiException::lancarExcessao(1);            
        }
        $enums = TipoInteresse::getValues();
        foreach ($enums as $enun) {
            $interesse = new Interesse();
            $interesse->codigo = $enun['codigo'];
            $interesse->descricao = $enun['descricao'];
            $interesse->status = false;
            $interesse->usuario_id = $usuario->id;
            $interesse->save();
        }
        return response()->json($interesse,201);
    }
}
