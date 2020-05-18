<?php
namespace App\Http\Controllers;
use App\Enums\TipoInteresse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Service\InteresseService;
use App\User;
use Exception;

class InteresseController extends Controller
{
    public function __construct()  {
    }

   
    public function testarEnum(User $usuario){ 
        /*
        $Enum = TipoInteresse::coerce('Supermercado');
        //$Enum = TipoInteresse::getInstance(Interesse::Supermercado);
        //$t = $Enum->getValues();
        $t = $Enum->value;
        $t['descricao'];
        $t['codigo'];
        */
       
        
        $enums = TipoInteresse::getValues();
        //$Enum = TipoInteresse::getInstance(Interesse::Supermercado);
        //$t = $Enum->getValues();
        /*
        $teste = "";
        foreach ($Enums as $enun) {
           $teste = $teste.$enun['codigo'];
        }
        */

        try {
            $interesseService = new InteresseService();
            $user = User::find(10);
    
            $interesseService->salvar($user);
        } catch (Exception $e) {
            //echo 'Exceção capturada: ',  $e->getMessage(), "\n";+
            return response()->json(['mensagem'=> $e->getMessage()],500);
        }
        

        
    }

}
