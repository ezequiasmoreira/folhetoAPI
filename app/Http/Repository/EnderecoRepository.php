<?php
namespace App\Http\Repository;
use App\Endereco;

class EnderecoRepository
{
    public $userService;
    public function __construct()  {    
    }
    public function obterPorId($id){
        $endereco = Endereco::where('id',$id)->first();
        return $endereco;
    }
   
}
