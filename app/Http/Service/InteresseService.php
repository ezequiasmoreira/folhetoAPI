<?php

namespace App\Http\Service;

use Illuminate\Http\Request;
use App\Enums\TipoInteresse;
use App\Http\Spec\InteresseSpec;
use App\Http\Repository\InteresseRepository;
use App\Exceptions\ApiException;
use App\Interesse;
use App\User;

class InteresseService
{
    public $usuarioService;
    public $interreseSpec;
    public $interesseRepository;
    public function __construct()  {
        $this->interreseSpec = new InteresseSpec();
        $this->interesseRepository = new InteresseRepository();
    }
    public function salvar (User $usuario){  
        $this->usuarioService = new UserService();
        $this->usuarioService->validarUsuario($usuario);              
        $interesse = Interesse::where('usuario_id',$usuario->id)->first();
        if($interesse){
            ApiException::throwException(1);            
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
        $this->usuarioService = new UserService();
        $tipoInteresses = TipoInteresse::getValues();            
        $interessesAtualizar = $request->toArray();   
        $quantidadeRegistro = count($interessesAtualizar);
        $quantidadeRegistroExigido = count($tipoInteresses);

        $argumentos =[
            'quantidadeRegistro' => $quantidadeRegistro,
            'quantidadeRegistroExigido' => $quantidadeRegistroExigido
        ];
        $this->interreseSpec->validarQuantidadePermitido($argumentos);

        $primeiroUsuario =0;     
        $incremento = 0;               
        foreach ($interessesAtualizar as $interesseAtualizar) {                                             
            $this->interreseSpec->validarStatusPermitido($interesseAtualizar['status']); 
            $usuario = $this->usuarioService->obterPorId($interesseAtualizar['usuario']); 
            $primeiroUsuario  = !$incremento ? $usuario->id : $primeiroUsuario; 
            $this->interreseSpec->validarUsuarioPermitido($primeiroUsuario,$usuario);       
            $this->interreseSpec->validarCodigoPermitido($tipoInteresses,$interesseAtualizar['codigo']);  
            $incremento++;              
        }
        return true;
    }
    public function atualizar (Request $request){  
        $interessesAtualizar = $request->toArray();   
        foreach ($interessesAtualizar as $interesseAtualizar) { 
            $usuarioId = $interesseAtualizar['usuario'];
            $codigo = $interesseAtualizar['codigo'];                                       
            $status = $interesseAtualizar['status'];                                       
            $interesse = $this->interesseRepository->obterPorUsuarioCodigo($usuarioId,$codigo);
            $this->validarInteresse($interesse);
            $interesse->status = $status;
            $interesse->Save();
        }                   
        return true;
    }
    public function excluirPorUsuario ($usuario){  
        $interesses = $this->interesseRepository->obterPorUsuario($usuario);  
        foreach ($interesses as $interesse) { 
            $interesse->delete();
        }            
        return true;
    }
    public function validarInteresse ($interesse){
        $this->interreseSpec->validarInteresse($interesse);
    }
}
