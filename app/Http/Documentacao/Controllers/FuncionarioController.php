<?php
namespace App\Http\Documentacao\Controllers;
use App\Http\Documentacao\Documentacao;
final class FuncionarioController implements Documentacao {  
      
    public function finalidade(){        
        return "Reposnsável por disponibilizar os recursos do funcionário";
    }
    public function salvar(){
        $retorno = [
            'mensagem' => 'Salva um funcionário, o recurso cria um usuário com perfil de funcionario e vincula
            a empresa do usuário que está cadastrando o funcionario.',
            'verbo' => 'post',
            'url' => 'http://localhost:8000/api/funcionario/salvar',
            'json-esperado' => [
                "name"                  => "Teste de funcionário",
                "email"                 => "funcionario@email.com",
                "password"              => "secret",
                "password_confirmation" => "secret",
                "rua"                   => "Líbano jose",
                "numero"                =>150,
                 "bairro"               => "Santa Luzia",
                "complemento"           => "SN",
                "cep"                   => "88852-536",
                "cidade_id"             =>2                    
                ]                            
            ];       
        return $retorno;
    }
    public function atualizar(){
        $retorno = [
            'mensagem' => 'Atualiza um funcionário, o recurso atualiza o usuário e o endereço vinculado ao funcionário
            somente o proprietário da empresa que o funcionário que está vinculado pode atualizar, é necessario enviar a
            senha de confirmação ao atualizar um funcionário, para manter a senha atual ou modificar.',
            'verbo' => 'put',
            'url' => 'http://localhost:8000/api/funcionario/atualizar',
            'json-esperado' => [
                "id"                    => 20,
                "name"                  => "Teste de funcionário",
                "email"                 => "funcionario@email.com",
                "password"              => "secret",
                "password_confirmation" => "secret",
                "rua"                   => "Líbano jose",
                "numero"                =>150,
                 "bairro"               => "Santa Luzia",
                "complemento"           => "SN",
                "cep"                   => "88852-536",
                "cidade_id"             =>2                    
                ]                            
            ];       
        return $retorno;
    }   
    public function excluir(){
        $retorno = [
            'mensagem' => 'Recurso disponibilizado para excluir um funcionário, ao excluir um funciónario '.
            'é excluido o endereço vinculado e o usuário se não etiver vinculado a uma empresa.'.
            'Só pode excluir um funcionario o proprietário da empresa',
            'verbo' => 'delete',
            'url' => 'http://localhost:8000/api/funcionario/5/excluir',
        ];
                  
        return $retorno;
    }   
}

