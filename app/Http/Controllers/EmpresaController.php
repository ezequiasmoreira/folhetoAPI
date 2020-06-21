<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
        try {
            $this->empresaService->validar($request);        
            
            $empresa = Empresa::create($request->all());
        } catch (Exception $exception) {
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }
        return response()->json($empresa,201);
    }
    public function salvarLogo(Request $request){
        $fileName= "empresa_".$request->indice.".jpg";
        $path = $request->file('photo')->move(public_path("/empresa/"),$fileName);
        $photoUrl = url('/empresa/'.$fileName);
        $empresa = $this->getEmpresa($request->indice);
        $empresa->logo =  $photoUrl;
        $empresa->save();
        return response()->json(['url' =>  $photoUrl],200);
    }
    public function atualizar(Request $request){
        if (!$request->id){
            return response()->json(['mensagem' =>'Não informado a empresa para atualizar'],500);
        }
        $empresaUsuarioLogado = $this->obterEmpresaUsuarioLogado();
        if(!$empresaUsuarioLogado){
            return response()->json(['mensagem' =>'Não Permitido, usuário não possui empresa vinculada'],500);
        }
        if($request->id != $empresaUsuarioLogado->id){
            return response()->json(['mensagem' =>'Não Permitido, usuário não possui permissão para alterar a empresa'],500);
        }
        if($this->getEmpresa($request->id)->cpf != $request->cpf){
            $validator = Validator::make($request->all(), [
                'razao_social' => 'required|string|max:255',
                'nome_fantasia' => 'required|string|max:255',
                'cpf' => 'required|string|max:14|min:14|unique:empresas',
                'tipo' => 'required|string',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'razao_social' => 'required|string|max:255',
                'nome_fantasia' => 'required|string|max:255',
                'cpf' => 'required|string|max:14|min:14',
                'tipo' => 'required|string',
            ]);

        }
       

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $request->tipo = strtoupper($request->tipo);
        if(($request->tipo != "JURIDICA")&&($request->tipo != "FISICA")){
            return response()->json(['mensagem'=>'TIPO inválido'],500);
        }
        if(($request->tipo == "JURIDICA") && (!$request->cnpj)){
            return response()->json(['mensagem'=>'CNPJ não informado para pessoa jurídica'],500);
        }
        $empresa = $this->getEmpresa($request->id);
        $usuario = Auth::user();
        if($request->usuario_id != $usuario->id){
            return response()->json(['mensagem'=>'Não é possivel alterar o usuário vinculado a empresa'],500);
        }
        $empresa->update($request->all());
        return response()->json($empresa,200);
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
