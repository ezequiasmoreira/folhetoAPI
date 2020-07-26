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
            ['codigo'=> 5 ,'descricao'=> '? inválido(a).'],
            ['codigo'=> 6 ,'descricao'=> 'Código ? inválido, códigos permitido: ?.'],
            ['codigo'=> 7 ,'descricao'=> 'Não permitido. Usuário ? não possui permissão para alterar o usuário ?.'],
            ['codigo'=> 8 ,'descricao'=> 'Perfil ? inválido, perfis permitido: ?.'],
            ['codigo'=> 9 ,'descricao'=> 'Perfil ? inválido, para funcionário'],
            ['codigo'=> 10 ,'descricao'=> 'Usuário ? não está vinculado a empresa ?.'],
            ['codigo'=> 11 ,'descricao'=> '?'],
            ['codigo'=> 12 ,'descricao'=> 'Usuário com perfil de funcionário somente ser criado/atualizado, ao criar uma empresa ou criar um usuário vinculado a uma empresa.'],
            ['codigo'=> 13 ,'descricao'=> 'Tipo ? inválido. Tipos permitido: ?.'],
            ['codigo'=> 14 ,'descricao'=> '? obrigatório.'],
            ['codigo'=> 15 ,'descricao'=> 'Quantidade de digitos incorreta para o campo ?. Quantidade correta ?.'],
            ['codigo'=> 16 ,'descricao'=> 'Campo ? inválido. Formato esperado: ?.'],
            ['codigo'=> 17 ,'descricao'=> 'Usuário não possui permissão para salvar funcionário.'],
            ['codigo'=> 18 ,'descricao'=> 'Não foi possível salvar a empresa.'],
            ['codigo'=> 19 ,'descricao'=> 'Não foi possível salvar o funcionário.'],
            ['codigo'=> 20 ,'descricao'=> 'Usuário ? já esta vinculado a uma empresa.'],
            ['codigo'=> 21 ,'descricao'=> 'Não foi possível atualizar o perfil do usuário para FUNCIONARIO.'],
            ['codigo'=> 22 ,'descricao'=> 'Não informado ID da empresa para atualizar.'],
            ['codigo'=> 23 ,'descricao'=> 'Não Permitido, usuário não possui empresa vinculada.'],
            ['codigo'=> 24 ,'descricao'=> 'Não Permitido, empresa deve ser atualizada pelo proprietário.'],
            ['codigo'=> 25 ,'descricao'=> 'Não informado ID do funcionário para atualizar.'],
            ['codigo'=> 26 ,'descricao'=> 'Não foi possível Atualizar o funcionário. Problemas ao salvar ?.'],
            ['codigo'=> 27 ,'descricao'=> 'Usuário não possui permissão para excluir funcionário.'],
            ['codigo'=> 28 ,'descricao'=> 'Endereço está vinculado ao funcionário ou empresa.'],
            ['codigo'=> 29 ,'descricao'=> 'Erro ao excluir o endereço. FuncionarioId: ? EmpresaId: ? Origem: ? Indice da origem: ?'],
        ];
    }
}

