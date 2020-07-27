<?php
namespace App\Http\Repository;
use App\Interesse;

class InteresseRepository
{
    public $interesseService;
    public function __construct()  {            
    }
    public function obterPorUsuarioCodigo($usuarioId,$codigo){
        return Interesse::where(['usuario_id' => $usuarioId,'codigo'=> $codigo])->first(); 
    }   
    public function obterPorUsuario($usuario){
        return Interesse::where('usuario_id',$usuario->id)->get(); 
    }   
}
