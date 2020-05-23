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
    const Supermercado =    ['codigo'=> 1,'descricao'=>'Supermercados'];
    const Sapataria =       ['codigo'=> 2,'descricao'=>'Sapataria'];
    const Farmacia =        ['codigo'=> 3,'descricao'=>'Farmácia'];
    const Papelaria =       ['codigo'=> 4,'descricao'=>'Papelaria'];
    const Cosmetico =       ['codigo'=> 5,'descricao'=>'Cosméticos'];
    const Construcao =      ['codigo'=> 6,'descricao'=>'Material de construção'];
    const Beleza =          ['codigo'=> 7,'descricao'=>'Salão de beleza'];
    const Aumotomoveis =    ['codigo'=> 8,'descricao'=>'Automóveis'];
    const Alimentacao =     ['codigo'=> 9,'descricao'=>'Alimentação'];
    const Joalheria =       ['codigo'=> 10,'descricao'=>'Joalheria'];
}
