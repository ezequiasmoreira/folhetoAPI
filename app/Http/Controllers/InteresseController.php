<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Service\InteresseService;
use Exception;

class InteresseController extends Controller
{
    public function __construct()  {
    }

    public function atualizar(Request $request){   
        DB::beginTransaction();    
        try {
            $interesseService = new InteresseService(); 
            $interesseService->interessePermiteAtualizar($request);
            $interesseService->atualizar($request);
            DB::commit();                       
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(['mensagem'=> $exception->getMessage()],500);
        }
        return response()->json(['mensagem'=> 'Atualizado com sucesso'],200); 
    }

}
