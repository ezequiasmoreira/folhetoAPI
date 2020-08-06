<?php
namespace App\Http\Dto;
use App\Http\Service\EmpresaService;
use App\Http\Dto\UsuarioDTO;

class EmpresaDTO
{
    private $usuarioDTO;
    private $enderecoDTO;
    private $empresaService;   
    public function __construct()  {
    }
    public function obterEmpresa($empresa,$campos=null){  
        $this->usuarioDTO = new UsuarioDTO();
        $this->enderecoDTO = new EnderecoDTO();              

        $dto = [  
                'id'            => $empresa->id,
                'razao_social'  => $empresa->razao_social,
                'nome_fantasia' => $empresa->nome_fantasia,
                'cnpj'          => $empresa->cnpj,
                'tipo'          => $empresa->tipo,
                'logo'          => $empresa->logo,
                'endereco'      => isset($campos['endereco']) ? $this->enderecoDTO->obterEndereco($empresa->endereco,$campos['endereco']) : null,
                'usuario'       => isset($campos['usuario']) ? $this->usuarioDTO->obterUsuario($empresa->usuario,$campos['usuario']) : null,
            ];        
        return $dto;
    }
    public function obterEmpresaTemplate($empresa,$template=null){
        $this->usuarioDTO = new UsuarioDTO();
        $this->enderecoDTO = new EnderecoDTO();             

        $dto = array();
        isset($template['empresa.id'])              ? $dto = $dto  +   ['id'            => $empresa->id]            : true;
        isset($template['empresa.razao_social'])    ? $dto = $dto  +   ['razao_social'  => $empresa->razao_social]  : true;
        isset($template['empresa.nome_fantasia'])   ? $dto = $dto  +   ['nome_fantasia' => $empresa->nome_fantasia] : true;
        isset($template['empresa.cnpj'])            ? $dto = $dto  +   ['cnpj'          => $empresa->cnpj]          : true;
        isset($template['empresa.tipo'])            ? $dto = $dto  +   ['tipo'          => $empresa->tipo]          : true;
        isset($template['empresa.logo'])            ? $dto = $dto  +   ['logo'          => $empresa->logo]          : true;
        
        if(isset($template['empresa.endereco'])){
            $endereco = $this->enderecoDTO->obterEnderecoTemplate($empresa->endereco,$template['empresa.endereco']);
            $dto = $dto + ['endereco' => $endereco];
        }

        if(isset($template['empresa.usuario'])){
            $usuario = $this->usuarioDTO->obterUsuarioTemplate($empresa->usuario,$template['empresa.usuario']);
            $dto = $dto + ['usuario' => $usuario];
        }
        
        return $dto;
    }
}