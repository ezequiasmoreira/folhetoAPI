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
}

