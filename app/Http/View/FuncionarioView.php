<?php
namespace App\Http\View;

class FuncionarioView
{
    public function obterPadrao(){   
        /*
        return [
            'endereco'=>['cidade'=>['estado'=>['pais'=>true]]],            
            'empresa'=>['endereco'=>['cidade'=>['estado'=>['pais'=>true]]],
                'usuario'=>true
            ],
           
        ]; 
        */      
        return [
            'endereco'=>['cidade'=>['estado'=>['pais'=>true]]],            
            'empresa'=>true,
        ]; 
    }
    public function obterlistarEditar(){         
        return [
            'funcionario.id' =>true,            
            'funcionario.name'=>true,
            'funcionario.email'=>true,
            'funcionario.endereco'=>[
                'endereco.id'=>true,
                'endereco.rua'=>true,
                'endereco.cep'=>true,
                'endereco.cidade'=>[
                    'cidade.id'=>true,
                    'cidade.nome'=>true,
                    'cidade.estado' => [
                        'estado.id' =>true,
                        'estado.nome' =>true,
                        'estado.sigla' =>true,
                        'estado.pais'=>[
                            'pais.id'=> true,
                            'pais.nome' =>false,
                            'pais.sigla' =>true,
                        ],
                    ],
                ]
            ],
            'funcionario.empresa'=>[
                'empresa.id'=>true,
                'empresa.razao_social'=>true
            ]            
        ];   
    }
    public function obterlistar(){         
        return [
            'funcionario.id' =>true,            
            'funcionario.name'=>true,
            'funcionario.endereco'=>[                
                'endereco.cidade'=>[
                    'cidade.nome'=>true,
                    'cidade.estado' => [
                        'estado.sigla' =>true,
                    ],
                ]
            ]
        ];   
    }
    
}
