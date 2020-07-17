<?php
namespace App;
use App\Http\Service\EmpresaService;

$debug = new Debug();
class Debug {
    public $controler;
    public function __construct()  {
        $this->debugar();
    }
    public function debugar(){
        $this->controler = new EmpresaService();
        $dados =[
            "razao_social"=>"Folheto Virtual LTDA",
            "nome_fantasia"=>"Folheto Virtual",
            "cpf"=>"101.986.897-44",
            "cnpj"=>"59.485.038/0001-44",
            "tipo"=>"JURIDICA",
            "rua"=>"São bernado",
            "numero"=>150,
             "bairro"=>"Centro",
            "complemento"=>"Proxximo a esucri",
            "cep"=>"88852-536",
            "cidade_id"=>2                 
        ];
            $this->controler->salvar($dados);
    }

}