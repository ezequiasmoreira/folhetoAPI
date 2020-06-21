<?php
namespace App\Http\Spec;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Validator;

class EmpresaSpec
{
    public function __construct()  {
    }

    public function validarCamposObrigatorioSalvar($request){        
        $validator = Validator::make($request->all(), [
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|min:14|unique:empresas',
            'tipo' => 'required|string',
        ]);
        if($validator->fails()){
            ApiException::lancarExcessao(11,$validator->errors()->toJson());
        }
        return true;      
    }
    
}