<?php
namespace App\Helpers;
class OrdenarArray{
    public function Descendete($array, $on)
    {
        $array_aux = array();
        foreach ($array as $object) {
            array_push($array_aux, (array) $object);
        }
        usort($array_aux, function ($array1,$array2) use($on){
            $patterns = array(
                'a' => '(á|à|â|ä|Á|À|Â|Ä)',
                'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
                'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
                'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
                'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
            );
            $array1[$on] = preg_replace(array_values($patterns), array_keys($patterns), $array1[$on]);
            $array2[$on] = preg_replace(array_values($patterns), array_keys($patterns), $array2[$on]);
            return strcasecmp($array2[$on], $array1[$on]);
        });
        $array = [];
        foreach ($array_aux as $a) {
            array_push($array, (object) $a);
        }
        return $array;
    }
    public function Ascendente($array, $on)
    {
        $array_aux = array();
        foreach ($array as $object) {
            array_push($array_aux, (array) $object);
        }
        usort($array_aux, function ($array1,$array2) use($on){
            $patterns = array(
                'a' => '(á|à|â|ä|Á|À|Â|Ä)',
                'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
                'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
                'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
                'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
            );
            $array1[$on] = preg_replace(array_values($patterns), array_keys($patterns), $array1[$on]);
            $array2[$on] = preg_replace(array_values($patterns), array_keys($patterns), $array2[$on]);
            return strcasecmp($array1[$on], $array2[$on]);
        });
        $array = [];
        foreach ($array_aux as $a) {
            array_push($array, (object) $a);
        }
        return $array;
    }
    public function AscendenteDosCampos($array, $on1, $on2)
    {
        $array_aux = array();
        foreach ($array as $object) {
            array_push($array_aux, (array) $object);
        }
        $aux1 = array_column($array_aux, $on1);
        $aux2 = array_column($array_aux, $on2);
        setlocale(LC_ALL,"es");
        array_multisort($aux1, SORT_ASC, SORT_LOCALE_STRING,$aux2, SORT_ASC, SORT_LOCALE_STRING, $array_aux);
        $array = [];
        foreach ($array_aux as $a) {
            array_push($array, (object) $a);
        }
        return $array;
    }
}
