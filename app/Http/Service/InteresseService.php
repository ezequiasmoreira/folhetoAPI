<?php

namespace App\Http\Service;

use Illuminate\Http\Request;
use App\Enums\TipoInteresse;
use App\Http\Spec\InteresseSpec;
use App\Exceptions\ApiException;
use App\Interesse;
use App\User;

class InteresseService
{
    public $usuarioService;
    public $interreseSpec;
    public function __construct()  {
        $this->usuarioService = new UserService();
        $this->interreseSpec = new InteresseSpec();
    }
    public function salvar (User $usuario){  
        //$usuarioLogado = $this->usuarioService->obterUsuarioLogado();                
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
        return true;
    }
    public function interessePermiteAtualizar (Request $request){  
            $tipoInteresses = TipoInteresse::getValues();            
            $interessesAtualizar = $request->toArray();   
            $quantidadeRegistro = count($interessesAtualizar);
            $quantidadeRegistroExigido = count($tipoInteresses);

            $argumentos =[
                'quantidadeRegistro' => $quantidadeRegistro,
                'quantidadeRegistroExigido' => $quantidadeRegistroExigido
            ];
            $this->interreseSpec->validarQuantidadePermitido($argumentos);
                                
            foreach ($interessesAtualizar as $interesseAtualizar) {               
                $this->interreseSpec->validarStatusPermitido($interesseAtualizar['status']); 
                $this->usuarioService->obterPorId($interesseAtualizar['usuario']);          
                $this->interreseSpec->validarCodigoPermitido($tipoInteresses,$interesseAtualizar['codigo']);                
            }
        return true;
    }
    public function atualizar (Request $request){  
        /*                
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
        }*/
        return true;
    }
}
