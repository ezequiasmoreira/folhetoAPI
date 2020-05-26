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
            ['codigo'=> 1 ,'descricao'=> 'Usuário já possui interesses cadastrado'],
            ['codigo'=> 2 ,'descricao'=> 'Quantidade de interesses ? é diferente da quantidade exigido ?.'],
            ['codigo'=> 3 ,'descricao'=> 'Informado mais de um usuário para atualizar os interesses'],
            ['codigo'=> 4 ,'descricao'=> 'O valor informado ? para status não é permitido, deve ser enviado ?.'],
            ['codigo'=> 5 ,'descricao'=> '? inválido.'],
            ['codigo'=> 6 ,'descricao'=> 'Código ? inválido, códigos permitido: ?.'],
            ['codigo'=> 7 ,'descricao'=> 'Não permitido. Usuário ? não possui permissão para alterar o usuário ?.'],
            ['codigo'=> 8 ,'descricao'=> 'Perfil ? inválido, perfis permitido: ?.'],
        ];
    }
}

