<?php

namespace App\Exceptions;


class ExceptionMensagem
{
    public static function obterMensagem ($codigo){
        $mensagens = ExceptionMensagem::todasMensagem();
        foreach ($mensagens as $mensagem) {            
            if ($mensagem['codigo'] == $codigo){
                return $mensagem['descricao'];
            }
        }        
        return '';
    }
    public static function todasMensagem(){
        return[
            ['codigo'=> 1 ,'descricao'=> 'Usuário já possui interreses cadastrado'],
        ];
    }
}

