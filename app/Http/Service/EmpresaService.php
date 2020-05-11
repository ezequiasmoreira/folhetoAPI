<?php

namespace App\Http\Service;
use Illuminate\Support\Facades\Auth;
use App\Empresa;

class EmpresaService
{
    public function __construct()  {
        $this->empresa = new Empresa();
    }
    public function obterEmpresaUsuarioLogado(){
        $usuario = Auth::user();
        /*if ($usuario->perfil == 'funcionario'){
            $funcionario = Funcionario::where('usuario_id',$usuario->id)->get('*');
            $empresa = $this->getEmpresa($funcionario->empresa_id);
            return $empresa;
        }
        */
        $empresa = Empresa::where('usuario_id',$usuario->id)->first();
        return $empresa;
    }
}
