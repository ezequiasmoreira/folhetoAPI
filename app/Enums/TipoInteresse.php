<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TipoInteresse extends Enum
{
    const Supermercado =    ['codigo'=> 0,'descricao'=>'Supermercados'];
    const Sapataria =       ['codigo'=> 1,'descricao'=>'Sapataria'];
    const Farmacia =        ['codigo'=> 2,'descricao'=>'Farmácia'];
    const Papelaria =       ['codigo'=> 3,'descricao'=>'Papelaria'];
    const Cosmetico =       ['codigo'=> 4,'descricao'=>'Cosméticos'];
    const Construcao =      ['codigo'=> 5,'descricao'=>'Material de construção'];
    const Beleza =          ['codigo'=> 6,'descricao'=>'Salão de beleza'];
    const Aumotomoveis =    ['codigo'=> 7,'descricao'=>'Automóveis'];
    const Alimentacao =     ['codigo'=> 8,'descricao'=>'Alimentação'];
    const Joalheria =       ['codigo'=> 9,'descricao'=>'Joalheria'];
}
