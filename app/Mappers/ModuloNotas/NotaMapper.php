<?php
namespace App\Mappers\ModuloNotas;

use App\NotaAcademica;
use App\ViewModel\ModuloNotas\NotaViewModel;

class NotaMapper
{
    public function ModelToViewModel(NotaAcademica $_notaAcademica)
    {
        $_notaAcademicaVM = new NotaViewModel();
        $_notaAcademicaVM->id =$_notaAcademica->MP_NIV_ID;
        $_notaAcademicaVM->nivel =$_notaAcademica->MP_NIV_notaAcademica;
        return $_notaAcademicaVM;
    }
    public function ListModelToViewModel($_notas)
    {
        $_listNotas = [];
        foreach ($_notas as $nota) {
            array_push($_listNotas, self::ModelToViewModel($nota));
        }
        return $_listNotas;
    }
}
