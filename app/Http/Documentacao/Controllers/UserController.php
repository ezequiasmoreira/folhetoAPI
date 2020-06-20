<?php
namespace App\Http\Documentacao\Controllers;
use App\Http\Documentacao\Documentacao;
final class UserController implements Documentacao {  
      
    public function finalidade(){        
        return "Reposnsavel por disponibilizar os recursos do usuário";
    }
    public function cadastrar(){
        $retorno = [
            'mensagem' => 'Salva um usuário no sistema, ao salvar o usuário também salva os interreses ".
            "vinculado ao usuário cadastrado, para posteriormente ser atualizado',
            'verbo' => 'post',
            'url' => 'http://localhost:8000/api/usuario/salvar',
            'json-esperado' => ["name"      => "Test Man",
                                "email"     => "test@email.com",
                                "password"  => "secret",
                                "password_confirmation" => "secret",
                                "perfil" => "",
                            ],
            ];        
        return $retorno;
    }
}

