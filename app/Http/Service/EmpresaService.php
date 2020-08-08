<?php
namespace App\Http\Service;
use App\Exceptions\ApiException;
use App\Empresa;
use App\Enums\Perfil;
use App\Http\Repository\EmpresaRepository;
use App\Http\Spec\EmpresaSpec;
use App\Http\Service\EnderecoService;
use App\Http\Service\FuncionarioService;
use App\Http\Service\UserService;
use App\Http\Service\UtilService;
use App\User;
use Illuminate\Http\Request;

class EmpresaService
{
    private $enderecoService;
    private $usuarioService;
    private $funcionarioService;
    private $empresaRepository;
    private $utilService;
    private $empresaSpec;

    public function __construct()  
    {
        $this->empresaSpec = new EmpresaSpec();
        $this->empresaRepository = new EmpresaRepository();
    }

    public function usuarioPossuiEmpresa(User $usuario)
    { 
        return $usuario->empresa ? true : false;        
    }

    public function obterEmpresaPorUsuario(User $usuario)
    {   
        $this->funcionarioService = new FuncionarioService();     
        $empresa = $this->empresaRepository->obterEmpresaPorUsuario($usuario);
        if($empresa){
            return $empresa;
        }
        $funcionario = $this->funcionarioService->obterFuncionarioPorUsuario($usuario);
        if(!$funcionario){
            return false;
        }
        return $funcionario->empresa; 
    }

    public function validarRequisicaoAtualizar(Request $request)
    {
        $this->empresaSpec = new EmpresaSpec();
        $this->usuarioService = new UserService();       
        
        $this->empresaSpec->validarCamposObrigatorioAtualizar($request); 
        $usuario = $this->usuarioService->obterUsuarioLogado();
        $this->empresaSpec->validarVinculoEmpresaPorUsuario($usuario);
        $empresa = $this->obterPorId($request->id);   
        $this->empresaSpec->permiteAlterarUsuario($empresa);
        $this->empresaSpec->validarTipo($request->tipo);
        $this->empresaSpec->validarTipoJuridica($request); 
        return true;
    }

    public function validarRequisicao(Request $request)
    {
        $this->empresaSpec = new EmpresaSpec();      
        
        $this->empresaSpec->validarCamposObrigatorioSalvar($request);
        $this->empresaSpec->validarRegraParaCriarEmpresa();        
        $this->empresaSpec->validarTipo($request->tipo);
        $this->empresaSpec->validarTipoJuridica($request); 
        return true;
    }

    public function validar($empresa)
    {
        $this->empresaSpec = new EmpresaSpec();
        $this->empresaSpec->validar($empresa);       
        return true;
    }

    public function obterPorId(int $empresa_id)
    {
        $empresa = $this->empresaRepository->obterPorId($empresa_id);
        $this->empresaSpec->validar($empresa);       
        return $empresa;
    }

    public function salvar($request)
    {
        $this->utilService = new UtilService();
        $this->usuarioService = new UserService();
        $this->enderecoService = new EnderecoService();
        $this->funcionarioService = new FuncionarioService();

        $endereco = $this->enderecoService->salvar($request);
        $this->enderecoService->validar($endereco);
        $usuarioLogado = $this->usuarioService->obterUsuarioLogado();

        $empresa = new Empresa();
        $empresa->codigo = $request->codigo;
        $empresa->razao_social = $request->razao_social;
        $empresa->nome_fantasia = $request->nome_fantasia;
        $empresa->cnpj = $request->cnpj;
        $empresa->cpf = $request->cpf;
        $empresa->tipo = $request->tipo;
        $empresa->endereco_id = $endereco->id;
        $empresa->usuario_id = $usuarioLogado->id;
        $salvou = $empresa->save();
        
        $this->utilService->validarStatus($salvou,true,18);  
        $this->usuarioService->atualizarPerfilFuncionario($empresa,$usuarioLogado);      
        $this->funcionarioService->salvar($usuarioLogado,$empresa,$endereco,"Empresa");        
        return true;
    }

    public function atualizar($request)
    { 
        $empresa = $this->obterPorId($request->id);
        $empresa->update($request->all());     
        return true;
    }

    public function obterEmpresaPorEndereco($endereco,$validaRetorno=true)
    { 
        $empresa = $this->empresaRepository->obterEmpresaPorEndereco($endereco);
        ($validaRetorno) ? $this->empresaSpec->validar($empresa) : true;
        return $empresa;
    }

    public function excluir(Empresa $empresa)
    {
        $this->funcionarioService   = new FuncionarioService();
        $this->usuarioService       = new UserService();
        $this->enderecoService      = new EnderecoService();

        $this->empresaSpec->permiteExcluirEmpresa($empresa);
        $usuarioProprietario        = $empresa->usuario;
        $funcionarioProprietario    = $usuarioProprietario->funcionario;
        $endereco                   = $funcionarioProprietario->endereco;
        $funcionarios               = $empresa->funcionarios;

        foreach ($funcionarios as $funcionario) 
        {
            if($funcionarioProprietario->id != $funcionario->id)
            {
                $this->funcionarioService->excluir($funcionario,'Empresa');
            }
        }

        $empresa->delete();        
        $this->enderecoService->excluir($endereco);
        $perfilUsuario = Perfil::getValue('Usuario');
        $usuarioProprietario->perfil = $perfilUsuario; 
        $usuarioProprietario->save();
        $this->usuarioService->excluir($usuarioProprietario);
        return true;
    }
}
