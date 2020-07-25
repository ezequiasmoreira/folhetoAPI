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
            ApiException::throwException(2,$parametros); 
        }
    }
    public function validarStatusPermitido($status){
        if ($status != 1 && $status !=2){
            ApiException::throwException(4,$status.','.'1 ou 2'); 
        }
    }
    public function validarUsuarioPermitido($primeiroUsuario,$usuario){
        if ($primeiroUsuario != $usuario->id){
            ApiException::throwException(3); 
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
            ApiException::throwException(6,$codigoAtualizar.','.$codigos); 
        }
    }
    public function validarInteresse ($interesse){
        if(!$interesse){
            ApiException::throwException(5,'Interesse'); 
        }
    }
}
