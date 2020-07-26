<?php
namespace App\Http\Spec;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ApiException;
use App\Http\Service\EmpresaService;
use App\Http\Service\FuncionarioService;

class EnderecoSpec
{
    private $empresaService;
    private $funcionarioService;
    public function __construct()  {
    }
    
    public function validarCamposObrigatorioSalvar($request){  
        $validator = Validator::make($request->all(), [
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'required',
            'cep' => 'required|string|max:9|min:9',
            'cidade_id' => 'required',
        ]);
        if($validator->fails()){
            ApiException::throwException(11,$validator->errors()->toJson());
        }
        return true;    
    }
    public function validar($endereco){ 
        $this->existeEndereco($endereco);
        return true;    
    }
    public function validarParametrosParaExcluir($funcionario=null,$empresa=null,$origem=null,$origemId=null){       
        if((!$funcionario)&&(!$empresa)){
            return true;
        }
        if((!$origem) || (!$origemId)){
            ApiException::throwException(28);
        }
        if(($origem != 'Empresa') && ($origem != 'Funcionario')){
            $parametros=$funcionario->id.','.$empresa->id.','.$origem.','.$origemId;
            ApiException::throwException(29,$parametros);
        }
        return true;    
    }
    public function permiteExcluirEndereco($funcionario=null,$empresa=null,$origem,$origemId){         
        ($origem == 'Empresa')     ? $this->validarExcluirOrigemEmpresa($empresa,$origemId)         : true;
        ($origem == 'Funcionario') ? $this->validarExcluirOrigemFuncionario($funcionario,$empresa,$origemId) : true;
        return true;    
    }
    private function validarExcluirOrigemEmpresa($empresa,$origemId){ 
        //Implementar quando for criar a exclusão da empresa ou endereço da empresa
        return true;    
    }
    private function validarExcluirOrigemFuncionario($funcionario,$empresa,$origemId){            
        $this->funcionarioService = new FuncionarioService();
        $funcionarioOrigem = $this->funcionarioService->obterPorId($origemId);
        if($funcionarioOrigem->id != $funcionario->id){
            ApiException::throwException(28);
        }
        if(!$empresa){
            return true;   
        }
        return false; 
    }
    private function existeEndereco($endereco){ 
        if(!$endereco){
            ApiException::throwException(5,'Endereço');
        }
        return true;    
    }
}
