<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            DB::commit();      
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }        
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
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }        
        return response()->json(['url' =>  $photoUrl],200);
    }
    public function atualizar(Request $request){
        DB::beginTransaction();
        try {
            $this->empresaService->validarRequisicaoAtualizar($request);
            $this->empresaService->atualizar($request);
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
            $empresa = $this->empresaService->obterPorId($id);
            $this->empresaService->excluir($empresa);
            DB::commit(); 
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }       
        return response()->json(['mensagem' => 'excluído com sucesso'],200);
    }
}
