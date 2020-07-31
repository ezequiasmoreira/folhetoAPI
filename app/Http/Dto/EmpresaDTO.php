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
    public function obterEmpresa($empresa_id,$campos=null){  
        $this->usuarioDTO = new UsuarioDTO();
        $this->enderecoDTO = new EnderecoDTO();             
        $this->empresaService = new EmpresaService();        

        $empresa = $this->empresaService->obterPorId($empresa_id);
        $dto = [  
                'id'            => $empresa->id,
                'razao_social'  => $empresa->razao_social,
                'nome_fantasia' => $empresa->nome_fantasia,
                'cnpj'          => $empresa->cnpj,
                'tipo'          => $empresa->tipo,
                'logo'          => $empresa->logo,
                'endereco'      => isset($campos['endereco']) ? $this->enderecoDTO->obterEndereco($empresa->endereco_id,$campos['endereco']) : null,
                'usuario'       => isset($campos['usuario']) ? $this->usuarioDTO->obterUsuario($empresa->usuario_id,$campos['usuario']) : null,
            ];        
        return $dto;
    }
}