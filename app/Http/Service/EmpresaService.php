<?php
namespace App\Http\Service;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\Http\Spec\EmpresaSpec;
class EmpresaService
{
    private $empresaSpec;
    public function __construct()  {
        $this->empresaSpec = new EmpresaSpec();
        
    }
    public function obterEmpresaUsuarioLogado(){
        $usuario = Auth::user();
        if ($usuario->perfil == 'FUNCIONARIO'){
            $funcionario = Funcionario::where('usuario_id',$usuario->id)->get('*');
            $empresa = $this->getEmpresa($funcionario->empresa_id);
            return $empresa;
            
        }        
        $empresa = Empresa::where('usuario_id',$usuario->id)->first();
        return $empresa;
    }
    public function validarCamposObrigatorioSalvar($request){
        $this->empresaSpec->validarCamposObrigatorioSalvar($request);
        return true;
    }
}
