<?php
namespace App\Http\Repository;
use App\Http\Service\InteresseService;
use App\Interesse;

class InteresseRepository
{
    public $interesseService;
    public function __construct()  {      
    }
    public function obterPorUsuarioCodigo($usuarioId,$codigo){
        $this->interesseService = new InteresseService();
        $interesse = Interesse::where(['usuario_id' => $usuarioId,'codigo'=> $codigo])->first();  
        $this->interesseService->validarInteresse($interesse);
        return$interesse;
    }
   
}
