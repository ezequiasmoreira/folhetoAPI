<?php
namespace App\Http\Documentacao\Enums;
use App\Http\Documentacao\Documentacao;
final class TipoInteresse implements Documentacao {  
      
    public function finalidade(){
        return "Contém os tipo de interrese que os usuários poderão utilizar para exibir as ofertas de sua preferência .";
    }
}