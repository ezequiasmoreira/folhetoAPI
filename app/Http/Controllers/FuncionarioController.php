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
    public function salvar(Request $request){       
        $this->enderecoService = new EnderecoService();
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService();

        DB::beginTransaction();
        try {
            $endereco = $this->enderecoService->salvar($request);
            $this->usuarioService->validarCamposObrigatorioSalvar($request);
            $usuario = $this->usuarioService->salvar($request,'Funcionario');
            $usuarioLogado =  $this->usuarioService->obterUsuarioLogado();
            $empresa = $this->empresaService->obterEmpresaPorUsuario($usuarioLogado);
            $this->funcionarioService->salvar($usuario,$empresa,$endereco);  
            DB::commit(); 
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }            
        return response()->json(['mensagem'=> 'Salvo com sucesso'],200);
    }
    public function atualizar(Request $request) {
        DB::beginTransaction();
        try {
            $this->funcionarioService->validarRequisicaoAtualizar($request);
            $this->funcionarioService->atualizar($request);
            DB::commit(); 
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }

        return response()->json(['mensagem'=> 'Atualizado com sucesso'],200);
    }

    public function excluir($id) {
        DB::beginTransaction();
        try {
            $this->funcionarioService->excluir($id);
            DB::commit(); 
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }
        
        return response()->json(['mensagem' => 'Excluído com sucesso'],200);
    }
    public function obterFuncionarios() {
        try {
            $dto = $this->funcionarioService->obterFuncionarios();
        } catch (Exception $exception) {
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }        
        return response()->json($dto,200);
    }
    public function obterFuncionario($id) {
        try {
            $dto = $this->funcionarioService->obterFuncionario($id);
        } catch (Exception $exception) {
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }        
        return response()->json($dto,200);
    }
    public function obterFuncionarioTemplate($id,$template) {
        try {
            $dto = $this->funcionarioService->obterFuncionarioTemplate($id,$template);
        } catch (Exception $exception) {
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }        
        return response()->json($dto,200);
    }
    public function obterFuncionariosTemplate($template) {
        try {
            $dto = $this->funcionarioService->obterFuncionariosTemplate($template);
        } catch (Exception $exception) {
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }        
        return response()->json($dto,200);
    }
}
