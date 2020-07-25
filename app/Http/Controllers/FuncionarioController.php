<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Funcionario;
use App\Http\Documentacao\Enums\Perfil;
use App\Http\Service\EmpresaService;
use App\Http\Service\UserService;
use App\Http\Service\EnderecoService;
use App\Http\Service\FuncionarioService;
use Exception;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    private $empresaService;
    private $usuarioService;
    private $enderecoService;
    private $funcionarioService;
    private $funcionario;
    public function __construct()  {
        $this->funcionario = new Funcionario();
        $this->funcionarioService = new FuncionarioService();
    }
/*
{
	"name": "Funcionario teste",
    "email": "F@F13",
    "password": "mantena",
    "password_confirmation":"mantena",
    "rua":"São bernado",
    "numero":150,
     "bairro":"Centro",
    "complemento":"Proxximo a esucri",
    "cep":"88852-536",
    "cidade_id":2 
}*/
    public function salvar(Request $request){       
        $this->enderecoService = new EnderecoService();
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService();

        DB::beginTransaction();
        try {
            $endereco = $this->enderecoService->salvar($request);
            $usuario = $this->usuarioService->salvar($request,'Funcionario');
            $usuarioLogado =  $this->usuarioService->obterUsuarioLogado();
            $empresa = $this->empresaService->obterEmpresaPorUsuario($usuarioLogado);
            $this->funcionarioService->salvar($usuario,$empresa,$endereco);   
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }
        DB::commit();    
        return response()->json(['mensagem'=> 'Salvo com sucesso'],200);
    }

    public function excluir($id) {
        $empresa = new EmpresaService();
        $empresa = $empresa->obterEmpresaUsuarioLogado();
        $funcionario = $this->getFuncionario($id);
        if($empresa->id != $funcionario->empresa_id){
            return response()->json(['mensagem' => 'Funcionario não vinculado a empresa CNPJ '.$empresa->cnpj],500);
        }        
        $funcionario->delete();
        return response()->json(['mensagem' => 'Excluído com sucesso'],200);
    }
    protected function getFuncionario($id)  {
        return $this->funcionario->find($id);
    }
}
