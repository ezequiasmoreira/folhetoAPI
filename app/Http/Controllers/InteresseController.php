<?php
namespace App\Http\Controllers;
use App\Enums\TipoInteresse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Service\InteresseService;
use App\Exceptions\ApiException;
use App\Http\Service\UserService;
use Illuminate\Support\Facades\Auth;
use App\User;
use Exception;

class InteresseController extends Controller
{
    public function __construct()  {
    }

    public function testarEnum(Request $request){        
        try {
            $interesseService = new InteresseService(); 
            $interesseService->interessePermiteAtualizar($request);
           
            return response()->json($c,200);
            return response()->json(count($enums) ,200);
            $interesse = Interesse::where('usuario_id',1)->first();
            if($interesse){
                ApiException::lancarExcessao(1);            
            }
            $enums = TipoInteresse::getValues();
            foreach ($enums as $enun) {
            }
            $retorno = [
                'mensagem'=> 'Interreses cadastrado com sucesso!'
            ];
        } catch (Exception $e) {
            //echo 'Exceção capturada: ',  $e->getMessage(), "\n";+
            return response()->json(['mensagem'=> $e->getMessage()],500);
        }
        return response()->json(['mensagem'=> $retorno],200); 
        

        
    }

}
