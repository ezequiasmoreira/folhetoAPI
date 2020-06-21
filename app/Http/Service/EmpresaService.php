<?php
namespace App\Http\Service;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\Http\Spec\EmpresaSpec;
use App\Http\Service\EnderecoService;
use App\Http\Service\FuncionarioService;
use App\Http\Service\UserService;
use App\Http\Service\UtilService;
class EmpresaService
{
    private $enderecoService;
    private $usuarioService;
    private $funcionarioService;
    private $utilService;
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
    public function validarRequest($request){
         $this->empresaSpec = new EmpresaSpec();
        $this->empresaSpec->validarCamposObrigatorioSalvar($request);
        $this->empresaSpec->validarTipo($request->tipo);
        $this->empresaSpec->validarTipoJuridica($request);           
        return true;
    }
    public function validar($empresa){
        $this->empresaSpec = new EmpresaSpec();
        $this->empresaSpec->validar($empresa);       
        return true;
    }
    public function salvar($request){
        $this->utilService = new UtilService();
        $this->usuarioService = new UserService();
        $this->enderecoService = new EnderecoService();
        $this->funcionarioService = new FuncionarioService();
        $endereco = $this->enderecoService->salvar($request);
        $this->enderecoService->validar($endereco);
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();
        $empresa = new Empresa();
        $empresa->razao_social = $request->razao_social;
        $empresa->nome_fantasia = $request->nome_fantasia;
        $empresa->cnpj = $request->cnpj;
        $empresa->cpf = $request->cpf;
        $empresa->tipo = $request->tipo;
        $empresa->endereco_id = $endereco->id;
        $empresa->usuario_id = $usuarioLogado->id;
        $salvou = $empresa->save();
        $this->utilService->validarStatus($salvou,true,"Não foi possivel salvar a empresa");
        $this->usuarioService->atualizarPerfilFuncionario($empresa,$usuarioLogado);
        $this->funcionarioService->salvar($usuarioLogado,$empresa,$endereco);
        return true;
    }
}
