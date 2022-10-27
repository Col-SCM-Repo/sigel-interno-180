<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AulasController extends Controller
{
    //
    public function getAulasPorNivel( $nivelStr=null ){
        /* if(!$nivelStr) throw new BadRequestException('Error, parametros incorrectos'); */

        $longitudCadena = strlen($nivelStr);
        $departamentos = DB::connection('bio_start')->table('TB_USER_DEPT')->where('sDepartment', 'like', "$nivelStr%")->get()->toArray();
        $nombres = array_map( fn($department)=> substr($department->sDepartment, $longitudCadena+1 ), $departamentos);
        return $nombres;
    }

}
