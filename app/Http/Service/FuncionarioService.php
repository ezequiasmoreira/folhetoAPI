<?php
namespace App\Http\Service;
use App\Funcionario;
use App\Http\Repository\FuncionarioRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Service\UserService;
use App\Http\Service\EmpresaService;
use App\Http\Service\EnderecoService;
use App\Http\Service\UtilService;
use App\Http\Spec\FuncionarioSpec;
use App\Http\Dto\FuncionarioDTO;
use App\Exceptions\ApiException;
use App\Http\View\FuncionarioView;
use App\Enums\FuncionarioConsulta;

class FuncionarioService
{
    private $usuarioService;
    private $empresaService;
    private $enderecoService;
    private $utilService;
    private $funcionarioRepository;
    private $funcionarioSpec;
    private $funcionarioDTO;
    private $funcionarioView;
    public function __construct()  {
        $this->funcionarioRepository = new FuncionarioRepository();
        $this->funcionarioSpec = new FuncionarioSpec();
        $this->funcionarioDTO = new FuncionarioDTO();       
    }
    public function validarRequisicaoSalvar($request){
        $this->funcionarioSpec->validarCamposObrigatorioSalvar($request);
        return true;
    }
    public function validarRequisicaoAtualizar($request){        
        $this->funcionarioSpec->validarCamposObrigatorioAtualizar($request);
        return true;
    }
    public function atualizar($request){
        $this->usuarioService = new UserService();
        
        $funcionario = $this->obterPorId($request->id);       
        $usuario = $this->obterUsuarioPorFuncionario($funcionario);
        $endereco = $this->obterEnderecoPorFuncionario($funcionario);
        $this->funcionarioSpec->permiteSalvar($usuario);
        $this->atualizarUsuarioVinculado($request,$usuario);        
        $this->atualizarEnderecoVinculado($request,$endereco);
        return true;
    }
    public function excluir($id){
        $this->usuarioService = new UserService(); 
        $this->enderecoService = new EnderecoService();        
        $funcionario = $this->obterPorId($id);  
        $this->funcionarioSpec->permiteExcluirFuncionario($funcionario);                  
        $usuario =  $funcionario->usuario;         
        $endereco = $funcionario->endereco;             
        $this->usuarioService->excluir($usuario,'Funcionario');
        $this->enderecoService->excluir($endereco);        
        return true;
    }
    public function salvar($usuario,$empresa,$endereco,$origem="Funcionario"){
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService();        
        $this->enderecoService = new EnderecoService();
        $this->utilService = new UtilService();

        $this->empresaService->validar($empresa); 
        $this->enderecoService->validar($endereco);       
        $this->usuarioService->validarUsuario($usuario);        
        ($origem !="Empresa") ? $this->funcionarioSpec->permiteSalvar($usuario) : true;
        
        $funcionario = new Funcionario();
        $funcionario->codigo = ($origem !="Empresa") ? $this->obterCodigo($empresa): 1;
        $funcionario->usuario_id = $usuario->id;
        $funcionario->empresa_id = $empresa->id;
        $funcionario->endereco_id = $endereco->id;
        $salvou = $funcionario->save();
        $this->utilService->validarStatus($salvou,true,19);
        return true;
    }
    public function obterFuncionarioPorUsuario($usuario,$validaRetorno=true){
        $funcionario = $this->funcionarioRepository->obterFuncionarioPorUsuario($usuario);
        ($validaRetorno) ? $this->funcionarioSpec->validar($funcionario) : true;
        return $funcionario;
    }
    public function obterUsuarioPorFuncionario($funcionario){
        $this->usuarioService = new UserService();        
        $usuario = $this->usuarioService->obterPorId($funcionario->usuario_id);
        return $usuario;
    }
    public function obterEmpresaPorFuncionario($funcionario){
        $this->empresaService = new EmpresaService();        
        $empresa = $this->empresaService->obterPorId($funcionario->empresa_id);
        return $empresa;
    }
    public function obterEnderecoPorFuncionario($funcionario){
        $this->enderecoService = new EnderecoService();       
        $endereco = $this->enderecoService->obterPorId($funcionario->endereco_id);
        return $endereco;
    }
    public function obterFuncionarioPorEndereco($endereco,$validaRetorno=true){
        $funcionario = $this->funcionarioRepository->obterFuncionarioPorEndereco($endereco);       
        ($validaRetorno) ? $this->funcionarioSpec->validar($funcionario) : true;
        return $funcionario;
    }
    public function obterPorId($funcionarioId,$validaRetorno=true){
        $funcionario = $this->funcionarioRepository->obterPorId($funcionarioId);
        ($validaRetorno) ? $this->funcionarioSpec->validar($funcionario) : true;
        return $funcionario;
    }
    public function atualizarUsuarioVinculado($request,$usuario){
        $this->utilService = new UtilService();
        $usuario->name      = $request->name;
        $usuario->email     = $request->email;
        $usuario->password  = Hash::make($request->password);
        $salvou = $usuario->save();
        $this->utilService->validarStatus($salvou,true,26,'usuário');
        return true;
    }
    public function atualizarEnderecoVinculado($request,$endereco){
        $this->utilService = new UtilService();
        $endereco->rua          = $request->rua;
        $endereco->numero       = $request->numero;
        $endereco->bairro       = $request->bairro;
        $endereco->complemento  = $request->complemento;
        $endereco->cep          = $request->cep;
        $endereco->cidade_id    = $request->cidade_id;
        $salvou = $endereco->save();
        $this->utilService->validarStatus($salvou,true,26,'endereço');
        return true;
    }
    public function obterFuncionarioProprietario($funcionario){
        $this->usuarioService = new UserService();
        $empresa = $this->obterEmpresaPorFuncionario($funcionario);            
        $usuarioDoProprietario = $this->usuarioService->obterPorId($empresa->usuario_id);
        $funcionarioProprietario = $this->obterFuncionarioPorUsuario($usuarioDoProprietario);    
        return $funcionarioProprietario;
    }
    public function obterFuncionarios(){
        $this->usuarioService = new UserService();
        $this->funcionarioView = new FuncionarioView();

        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();            
        $funcionario = $this->obterFuncionarioPorUsuario($usuarioLogado);
        (Boolean)$ehProprietario = $this->funcionarioSpec->ehProprietario($funcionario);

        if (!$ehProprietario) return ''; 

        $metodo = FuncionarioConsulta::getValue("Padrao");        
        $campos = $this->funcionarioView->$metodo();              
        $empresa = $this->obterEmpresaPorFuncionario($funcionario);

        return $this->funcionarioDTO->obterFuncionarios($empresa,$campos);
    }
    public function obterFuncionario($funcionario_id){
        $this->usuarioService = new UserService();
        $this->funcionarioView = new FuncionarioView();

        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();            
        $funcionario = $this->obterFuncionarioPorUsuario($usuarioLogado);
        $funcionarioARetornar = $this->obterPorId($funcionario_id,false);
        (Boolean)$ehProprietario = $this->funcionarioSpec->ehProprietario($funcionario);
        (Boolean)$permiteRetornar = $this->funcionarioSpec->permiteRetornarFuncionario($funcionario,$funcionarioARetornar);
        
        if (!$ehProprietario || !$permiteRetornar) return '{}';

        $metodo = FuncionarioConsulta::getValue("Padrao");        
        $campos = $this->funcionarioView->$metodo();

        return $this->funcionarioDTO->obterFuncionario($funcionario_id,$campos);
    }
    public function obterFuncionarioTemplate($funcionario_id,$template){
        $this->usuarioService = new UserService();
        $this->funcionarioView = new FuncionarioView();
        
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();            
        $funcionario = $this->obterFuncionarioPorUsuario($usuarioLogado);
        $funcionarioARetornar = $this->obterPorId($funcionario_id);
        (Boolean)$ehProprietario = $this->funcionarioSpec->ehProprietario($funcionario);
        (Boolean)$permiteRetornar = $this->funcionarioSpec->permiteRetornarFuncionario($funcionario,$funcionarioARetornar);
        
        if (!$ehProprietario || !$permiteRetornar) return '{}';
            
        if($template){
            $metodo = FuncionarioConsulta::getValue($template);
            $template = $this->funcionarioView->$metodo();
        }                        
        return $this->funcionarioDTO->obterFuncionarioTemplate($funcionario_id,$template);
    }
    public function obterCodigo($empresa){
        (Integer) $codigo = $this->funcionarioRepository->obterProximoCodigo($empresa);
        return ++$codigo;      
    }
    public function obterFuncionariosTemplate($template){
        $this->usuarioService = new UserService();
        $this->funcionarioView = new FuncionarioView();
        
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();            
        $funcionario = $this->obterFuncionarioPorUsuario($usuarioLogado);
        (Boolean)$ehProprietario = $this->funcionarioSpec->ehProprietario($funcionario);

        if (!$ehProprietario) return ''; 
        $empresa = $this->obterEmpresaPorFuncionario($funcionario);   
        if($template){
            $metodo = FuncionarioConsulta::getValue($template);
            $template = $this->funcionarioView->$metodo();
        }                        
        return $this->funcionarioDTO->obterFuncionariosTemplate($empresa,$template);
    }

}
