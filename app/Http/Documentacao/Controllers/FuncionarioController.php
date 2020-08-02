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
    public function obterFuncionarios(){
        $retorno = [
            'mensagem' => 'Recurso disponibilizado para retornar todos funcionários que estão vinculado a empresa do proprietário',
            'verbo' => 'get',
            'url' => 'http://localhost:8000/api/funcionario/',
            'observacao'=>'Esta url não retorna as FK da empresa, para consultas com campos diferente, consulte a documentação da classe (Enums/FuncionarioConsulta)'
        ];                  
        return $retorno;
    }   
    public function obterFuncionario(){
        $retorno = [
            'mensagem' => 'Recurso disponibilizado para retornar um funcionário pelo ID que está vinculado a empresa do proprietário',
            'verbo' => 'get',
            'url' => 'http://localhost:8000/api/funcionario/23',
            'observacao'=>'Esta url não retorna as FK da empresa, para consultas com campos diferente, consulte a documentação da classe (Enums/FuncionarioConsulta)'
        ];                  
        return $retorno;
    }   
    public function obterFuncionarioTemplate(){
        $retorno = [
            'mensagem' => 'Recurso disponibilizado para retornar um funcionário pelo ID que está vinculado a empresa do proprietário'.
            ' esta consulta possui uma particularidade, é possivel enviar um template na URL, esse template define quais campos '. 
            'será retornado no json, atualmente é permitido dois formatos de campos Template/Campos',
            'verbo' => 'get',
            'url' => 'http://localhost:8000/api/funcionario/23/view/ListarEditar',
            'observacao'=>'Esta url não retorna as FK da empresa, o campo ListarEditar na url é definido na classe (Enums/FuncionarioConsulta) para maiores detalhes consulte a documentação da classe'
        ];                  
        return $retorno;
    }   
    public function obterFuncionariosTemplate(){
        $retorno = [
            'mensagem' => 'Recurso disponibilizado para retornar todos funcionários que está vinculado a empresa do proprietário'.
            ' esta consulta possui uma particularidade, é possivel enviar um template na URL, esse template define quais campos '. 
            'será retornado no json, atualmente é permitido dois formatos de campos Template/Campos',
            'verbo' => 'get',
            'url' => 'http://localhost:8000/api/funcionario/view/ListarEditar',
            'observacao'=>'Esta url não retorna as FK da empresa, o campo ListarEditar na url é definido na classe (Enums/FuncionarioConsulta) para maiores detalhes consulte a documentação da classe'
        ];                  
        return $retorno;
    }   
}










