<?php
namespace App\Http\Documentacao\Enums;
use App\Http\Documentacao\Documentacao;
final class Perfil implements Documentacao {  
      
    public function finalidade(){
        return "Contém os perfis disponivel na aplicação, sendo que o perfil de usuário é um perfil comumm.
        Todo funcionário é um Usuário porém os usúarios com o perfil de funcionário está vinculado a uma empresa.";
    }
}
