<?php
namespace App\Http\Repository;
use App\User;

class UserRepository
{
    public $userService;
    public function __construct()  {    
    }
    public function obterPorId($id){
        $this->userService = new UserService();
        $usuario = User::where('id',$id)->first();
        return $usuario;
    }
   
}
