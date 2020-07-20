<?php
namespace App\Http\Documentacao\Controllers;
use App\Http\Documentacao\Documentacao;
final class EmpresaController implements Documentacao {  
      
    public function finalidade(){        
        return "Reposnsável por disponibilizar os recursos da empresa";
    }
    public function salvar(){
        $retorno = [
            'mensagem' => 'Salva uma empresa no sistema, ao salvar empresa também converte o usuario para perfil 
             de  funcionario e cria um funncionario vinculado ao usuario logado e a empresa que foi criada".',
            'verbo' => 'post',
            'url' => 'http://localhost:8000/api/empresa/salvar',
            'json-esperado' => [
                "razao_social"  =>"Folheto Virtual LTDA",
                "nome_fantasia" =>"Folheto Virtual",
                "cpf"           =>"101.986.897-44",
                "cnpj"          =>"59.485.038/0001-44",
                "tipo"          =>"JURIDICA",
                "rua"           =>"São bernado",
                "numero"        =>150,
                 "bairro"       =>"Centro",
                "complemento"   =>"Proxximo a esucri",
                "cep"           =>"88852-536",
                "cidade_id"     =>2                    
                ]                            
            ];        
        return $retorno;
    }
    
}

