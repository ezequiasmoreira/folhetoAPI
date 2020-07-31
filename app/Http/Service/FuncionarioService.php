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

class FuncionarioService
{
    private $usuarioService;
    private $empresaService;
    private $enderecoService;
    private $utilService;
    private $funcionarioRepository;
    private $funcionarioSpec;
    private $funcionarioDTO;
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
        $usuario = $this->obterUsuarioPorFuncionario($funcionario);        
        $endereco = $this->obterEnderecoPorFuncionario($funcionario);
        $this->enderecoService->excluir($endereco,'Funcionario',$id);        
        $this->usuarioService->excluir($usuario,'Funcionario');
        $funcionario->delete();
        return true;
    }
    public function salvar($usuario,$empresa,$endereco){
        $this->usuarioService = new UserService();
        $this->empresaService = new EmpresaService();        
        $this->enderecoService = new EnderecoService();
        $this->utilService = new UtilService();

        $this->empresaService->validar($empresa); 
        $this->enderecoService->validar($endereco);       
        $this->usuarioService->validarUsuario($usuario);
        $this->funcionarioSpec->permiteSalvar($usuario);
        
        $funcionario = new Funcionario();
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
    public function obterPorId($funcionarioId){
        $funcionario = $this->funcionarioRepository->obterPorId($funcionarioId);
        $this->funcionarioSpec->validar($funcionario);
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
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();            
        $funcionario = $this->obterFuncionarioPorUsuario($usuarioLogado);
        (Boolean)$ehProprietario = $this->funcionarioSpec->ehProprietario($funcionario);

        if (!$ehProprietario) return ''; 

        $campos =[
            'endereco'=>['cidade'=>['estado'=>['pais'=>true]]],            
            'empresa'=>['endereco'=>['cidade'=>['estado'=>['pais'=>true]]]],
        ];
        $empresa = $this->obterEmpresaPorFuncionario($funcionario);
        return $this->funcionarioDTO->obterFuncionarios($empresa,$campos);
    }
    public function obterFuncionario($funcionario_id){
        $this->usuarioService = new UserService();
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();            
        $funcionario = $this->obterFuncionarioPorUsuario($usuarioLogado);
        $funcionarioARetornar = $this->obterPorId($funcionario_id);
        (Boolean)$ehProprietario = $this->funcionarioSpec->ehProprietario($funcionario);
        (Boolean)$permiteRetornar = $this->funcionarioSpec->permiteRetornarFuncionario($funcionario,$funcionarioARetornar);
        
        if (!$ehProprietario || !$permiteRetornar) return '{}';
        
        $campos =[
            'endereco'=>['cidade'=>['estado'=>['pais'=>true]]],            
            'empresa'=>true,
        ];
        return $this->funcionarioDTO->obterFuncionario($funcionario_id,$campos);
    }
    public function obterFuncionarioTemplate($funcionario_id,$templateCodigo){
        $this->usuarioService = new UserService();
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();            
        $funcionario = $this->obterFuncionarioPorUsuario($usuarioLogado);
        $funcionarioARetornar = $this->obterPorId($funcionario_id);
        (Boolean)$ehProprietario = $this->funcionarioSpec->ehProprietario($funcionario);
        (Boolean)$permiteRetornar = $this->funcionarioSpec->permiteRetornarFuncionario($funcionario,$funcionarioARetornar);
        
        if (!$ehProprietario || !$permiteRetornar) return '{}';
        
        $template =[
            'funcionario.id' =>true,            
            'funcionario.name'=>true,
            'funcionario.email'=>true,
            'funcionario.endereco'=>[
                'endereco.id'=>true,
                'endereco.rua'=>true,
                'endereco.cep'=>true,
                'endereco.cidade'=>[
                    'cidade.id'=>true,
                    'cidade.nome'=>true,
                    'cidade.codigo'=>true,
                    'cidade.estado' => [
                        'estado.id' =>true,
                        'estado.nome' =>true,
                        'estado.codigo' =>true,
                        'estado.sigla' =>true,
                        'estado.pais'=>[
                            'pais.id'=> true,
                            'pais.nome' =>false,
                            'pais.codigo' =>true,
                            'pais.sigla' =>true,
                        ],
                    ],
                ]
            ]
        ];
        return $this->funcionarioDTO->obterFuncionarioTemplate($funcionario_id,$template);
    }
}
