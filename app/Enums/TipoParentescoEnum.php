<?php
namespace App\Enums;

abstract class TipoParentescoEnum
{
    const PADRE = 1;
    const MADRE = 2;
    const HERMANO_A = 3;
    const TIO_A = 4;
    const ABUELO_A = 5;
    const PADRASTRO = 6;
    const MADRASTRA = 7;
    const PRIMO_A = 8;
    const NANA = 9;
    const MADRE_ANFITRIONA = 11;

    public static function getName( int $cod_parentesco ){
        switch ($cod_parentesco) {
            case 1: return 'PADRE';
            case 2: return 'MADRE';
            case 3: return 'HERMANO(A)';
            case 4: return 'TIO(A)';
            case 5: return 'ABUELO(A)';
            case 6: return 'PADRASTRO';
            case 7: return 'MADRASTRA';
            case 8: return 'PRIMO(A)';
            case 9: return 'NANA';
            case 11: return 'MADRE_ANFITRIONA';

            default: return 'NO DEFINIDO';
        }
    }

}
