<?php
namespace App\Helpers;
class OrdenarArray{
    public function Descendete($array, $on)
    {
        $new_array = array();
         $sortable_array = array();
         if (count($array) > 0) {
             foreach ($array as $k => $v) {
                 if (is_array($v)) {
                     foreach ($v as $k2 => $v2) {
                         if ($k2 == $on) {
                             $sortable_array[$k] = $v2;
                         }
                     }
                 } else {
                     $sortable_array[$k] = $v;
                 }
             }
             arsort($sortable_array);
             foreach ($sortable_array as $k => $v) {
                array_push($new_array,$array[$k]);
             }
         }
         return $new_array;
    }
    public function Ascendente($array, $on)
    {
        $new_array = array();
         $sortable_array = array();
         if (count($array) > 0) {
             foreach ($array as $k => $v) {
                 if (is_array($v)) {
                     foreach ($v as $k2 => $v2) {
                         if ($k2 == $on) {
                             $sortable_array[$k] = $v2;
                         }
                     }
                 } else {
                     $sortable_array[$k] = $v;
                 }
             }
             asort($sortable_array);
             foreach ($sortable_array as $k => $v) {
                array_push($new_array,$array[$k]);
             }
         }
         return $new_array;
    }
}
