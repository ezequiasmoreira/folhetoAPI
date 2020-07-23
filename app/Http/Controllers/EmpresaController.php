<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Service\EmpresaService;
use Exception;
use App\Empresa;

class EmpresaController extends Controller
{
    private $empresaService;
    public function __construct()  {
        $this->empresa = new Empresa();
        $this->empresaService = new EmpresaService();
    }
    public function salvar(Request $request){
        DB::beginTransaction();
        try {
            $this->empresaService->validarRequisicao($request);
            $this->empresaService->salvar($request);       
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }
        DB::commit();
        return response()->json(['mensagem'=> 'Salvo com sucesso'],200);
    }
    public function salvarLogo(Request $request){
        DB::beginTransaction();
        try {
            $fileName= "empresa_".$request->empresaId.".jpg";
            $path = $request->file('photo')->move(public_path("/empresa/"),$fileName);
            $photoUrl = url('/empresa/'.$fileName);
            $empresa = $this->empresaService->obterPorId($request->empresaId);
            $empresa->logo =  $photoUrl;
            $empresa->save();
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }
        DB::commit();
        return response()->json(['url' =>  $photoUrl],200);
    }
    public function atualizar(Request $request){
        DB::beginTransaction();
        try {
            $this->empresaService->validarRequisicaoAtualizar($request);
            $this->empresaService->atualizar($request);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }
        DB::commit();    
        return response()->json(['mensagem'=> 'Atualizado com sucesso'],200);
    }
    public function excluir($id) {
        $this->getEmpresa($id)->delete();
        return response()->json(['mensagem' => 'excluído com sucesso'],200);
    }
    protected function getEmpresa($id)  {
        return $this->empresa->find($id);
    }
    public function getEmpresaUsuarioLogado()  {      
        $empresa = $this->obterEmpresaUsuarioLogado();
        return response()->json($empresa,200);
    }
    protected function obterEmpresaUsuarioLogado(){
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
