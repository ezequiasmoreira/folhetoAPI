<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;

class InteresseSpec
{
    public function __construct()  {
    }
    public function validarQuantidadePermitido($argumentos){
        $quantidadeRegistro = $argumentos['quantidadeRegistro'];
        $quantidadeRegistroExigido = $argumentos['quantidadeRegistroExigido'];
        if ( $quantidadeRegistro != $quantidadeRegistroExigido) {
            $parametros = $quantidadeRegistro.','.$quantidadeRegistroExigido;
            ApiException::lancarExcessao(2,$parametros); 
        }
    }
    public function validarStatusPermitido($status){
        if ($status != 1 && $status !=2){
            ApiException::lancarExcessao(4,$status.','.'1 ou 2'); 
        }
    }
    public function validarUsuarioPermitido($primeiroUsuario,$usuario){
        if ($primeiroUsuario != $usuario->id){
            ApiException::lancarExcessao(3); 
        }
    }
    public function validarCodigoPermitido($tipoInteresses,$codigoAtualizar){
        $permitido = false;
        $codigos ='';
        foreach ($tipoInteresses as $tipoInteresse) {                    
            $codigos =  ($codigos != '' )? $codigos.' - '.$tipoInteresse['codigo']: $codigos.$tipoInteresse['codigo'];
            if($tipoInteresse['codigo'] == $codigoAtualizar){
                $permitido = true;
            }                    
        }
        if(!$permitido){
            ApiException::lancarExcessao(6,$codigoAtualizar.','.$codigos); 
        }
    }
    public function validarInteresse ($interesse){
        if(!$interesse){
            ApiException::lancarExcessao(5,'Interesse'); 
        }
    }
}
