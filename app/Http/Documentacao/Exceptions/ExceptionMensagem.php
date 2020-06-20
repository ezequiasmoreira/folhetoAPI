<?php
namespace App\Http\Documentacao\Exceptions;
use App\Http\Documentacao\Documentacao;
final class ExceptionMensagem implements Documentacao {  
      
    public function finalidade(){
        $retorno = [
            'mensagem' => 'Possui as mensagens das excessões lançada no sistema',
               'exemplo' => [
                    'parametros' => '$codigoAtualizar = 1 - 4 - 2; $codigos= 9 - 10;',
                    'aplicar' => ' ApiException::lancarExcessao(6,$codigoAtualizar.",".$codigos);' 
                ]
            ];
        return $retorno;
    }
}