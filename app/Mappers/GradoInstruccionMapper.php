<?php
namespace App\Mappers;

use App\GradoInstruccion;
use App\ViewModel\GradoInstruccionViewModel;

class GradoInstruccionMapper
{
    public function ModelToViewModel(GradoInstruccion $_gradoInstruccion)
    {
        $_gradoInstruccionVM = new GradoInstruccionViewModel();
        $_gradoInstruccionVM->id =$_gradoInstruccion->MP_GI_ID;
        $_gradoInstruccionVM->nombre =$_gradoInstruccion->MP_GI_NOMBRE;
        return $_gradoInstruccionVM;
    }
    public function ListModelToViewModel($_gradosInstruccion)
    {
        $_listGradosInstrucion = [];
        foreach ($_gradosInstruccion as $grado) {
            array_push($_listGradosInstrucion, self::ModelToViewModel($grado));
        }
        return $_listGradosInstrucion;
    }
}
