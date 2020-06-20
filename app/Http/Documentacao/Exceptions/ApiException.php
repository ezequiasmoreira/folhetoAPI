<?php
namespace App\Http\Documentacao\Exceptions;
use App\Http\Documentacao\Documentacao;
final class ApiException implements Documentacao {  
      
    public function finalidade(){
        return "Recebe como argumento o código da mensagem e os parametros separado por virgula,".
        "busca a mensagem pelo código na classe exceptionMensagem e substitui os caracteres ? pelos parametros ".
        "separados por virgula do primeiro para o último";
    }
}