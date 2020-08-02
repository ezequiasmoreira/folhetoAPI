<?php
namespace App\Http\Documentacao\Controllers;
use App\Http\Documentacao\Documentacao;
final class UserController implements Documentacao {  
      
    public function finalidade(){        
        return "Reposnsável por disponibilizar os recursos do usuário";
    }
    public function salvar(){
        $retorno = [
            'mensagem' => 'Salva um usuário no sistema, ao salvar o usuário também salva os interreses ".
            "vinculado ao usuário cadastrado, para posteriormente ser atualizado',
            'verbo' => 'post',
            'url' => 'http://localhost:8000/api/usuario/salvar',
            'json-esperado' => [
                                "name"      => "Test Man",
                                "email"     => "test@email.com",
                                "password"  => "secret",
                                "password_confirmation" => "secret",
                                "perfil" => "",
                            ],
            ];        
        return $retorno;
    }
    public function autenticar(){
        $retorno = [
            'mensagem' => 'Recurso para autenticar uma requisição de login do usuário".',
            'verbo' => 'post',
            'url' => 'localhost:8000/api/login',
            'json-esperado' => [
                                "email"     => "test@email.com",
                                "password"  => "secret",
                            ],
            ];         
        return $retorno;
    }
    public function atualizar(){
        $retorno = [
            'mensagem' => 'Recurso para atualizar o nome de um usuário".',
            'verbo' => 'put',
            'url' => 'http://localhost:8000/api/usuario/atualizar',
            'json-esperado' => [
                                "id"     => 25,
                                "name"   => "teste",
                            ],
            ];         
        return $retorno;
    }
    public function excluir(){
        $retorno = [
            'mensagem' => 'Recurso para excluir um usuario, ao excluir un endereço também é excluído os interesses".',
            'verbo' => 'delete',
            'url' => 'http://localhost:8000/api/usuario/44/excluir',            
            ];         
        return $retorno;
    }
}

