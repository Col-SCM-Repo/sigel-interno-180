<?php

namespace App\Http\Controllers;

use App\Religion;
use Illuminate\Http\Request;

class ReligionesController extends Controller
{
    public function ObtenerReligiones()
    {
        $religiones = [];
        $aux =  Religion::all();
        foreach ($aux as $rel) {
            $religion=[
                'id'=> $rel->id(),
                'religion'=> $rel->religion(),
            ];
            array_push($religiones,$religion);
        }
        return $religiones;
    }
}
