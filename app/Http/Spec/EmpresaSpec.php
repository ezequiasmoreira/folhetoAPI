<?php
namespace App\Http\Spec;
use App\Enums\Tipo;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Validator;
use App\Http\Service\UtilService;
use App\Http\Service\UserService;

class EmpresaSpec
{
    private $usuarioService;
    private $utilService;
    public function __construct()  {
       $this->utilService = new UtilService();
    }

    public function validarCamposObrigatorioSalvar($request){        
        $validator = Validator::make($request->all(), [
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|min:14|unique:empresas',
            'tipo' => 'required|string',
            'rua' => 'required|string|max:255',
            'numero' => 'required|integer',
            'bairro'  => 'required|string|max:255',
            'cep'  => 'required|string|max:10',
            'cidade_id'  => 'required|integer',   
        ]);
        if($validator->fails()){
            ApiException::lancarExcessao(11,$validator->errors()->toJson());
        }
        return true;      
    }
    public function validarTipo($tipo){ 
        $fisica = Tipo::getValue('Fisica'); 
        $juridica = Tipo::getValue('Juridica');           
        if(($fisica != $tipo)&&($juridica != $tipo)){
            ApiException::lancarExcessao(13,$tipo.','.$fisica.' - '.$juridica);
        }    
        return true;      
    }
    public function validarTipoJuridica($request){ 
        $juridica = Tipo::getValue('Juridica');
        if($request->tipo != $juridica){
            return true;
        }
        $this->utilService->validarCnpj($request->cnpj);
        return true;              
    }
    public function validar($empresa){ 
        $this->existeEmpresa($empresa);
        return true;              
    }
    public function validarRegraParaCriarEmpresa(){  
        $this->usuarioService = new UserService();       
        (boolean)$possuiEmpresa  = $this->usuarioService->usuarioLogadoPossuiEmpresa();
        $usuario =  $this->usuarioService->obterUsuarioLogado(); 
        $this->utilService->validarStatus($possuiEmpresa,true,20,$usuario->name);
        return true;              
    }
    private function existeEmpresa($empresa){ 
        if(!$empresa){
            ApiException::lancarExcessao(5,'Empresa');
        }
        return true;    
    }
    
    
}