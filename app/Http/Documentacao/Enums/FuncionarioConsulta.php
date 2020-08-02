<?php
namespace App\Http\Documentacao\Enums;
use App\Http\Documentacao\Documentacao;
final class FuncionarioConsulta implements Documentacao {  
      
    public function finalidade(){
        $retorno = [
            'finalidade' => 'Define os templates que serão utilizado nas consultas que exigem o retorno de campos especificos. ',
            'uso' => 'É possivel adicionar na url um parâmetro na consultas com verbo get Exemplo:(http://localhost:8000/api/funcionario/view/ListarEditar) '. 
            'ListarEditar é definido como um atributo do enum, e o valor é o nome do método criado na classe View/FuncionarioView '. 
            'É possível usar duas formas de definição de campos para retornar o json (template/campos)',
            'template' => 'O template exige que seja informada cada campo e somente é retornado os campos se informado '.
            '. As chaves estrangeira são retornada nos campos se informado no template',
            'template-exemplo' => [
                "funcionario.id => true, funcionario.name => true,funcionario.endereco=>[endereco.id=>true]"  
            ],
            'campos'=>'O formato de campos retorna todos os campos de uma tabela e a chave estrangeira é retornada se for informado. '. 
            'Caso não seja informado será retornado o valor nulo',
            'campos-exemplo para retornar os funcionarios, no exemplo abaixo retorna todos os campos do funcionario, todos o campos da cidade e do estado' => [
                "endereco=>[cidade=>[estado=>true]]"  
            ],
        ];  
        return $retorno;
    }
    
}
