<?php
namespace App\Mappers;

use App\Apoderado;
use App\Parentesco;
use App\ViewModel\ApoderadoViewModel;
use App\ViewModel\NivelViewModel;

class ApoderadoMapper
{
    public function ModelToViewModel(Parentesco $_parentesco, Apoderado $_apoderado)
    {
        $_apoderadoVM = new ApoderadoViewModel();
        $_apoderadoVM->id = $_apoderado->MP_APO_ID;
        $_apoderadoVM->nombres = $_apoderado->MP_APO_NOMBRES;
        $_apoderadoVM->apellidos = $_apoderado->MP_APO_APELLIDOS;
        $_apoderadoVM->dni = $_apoderado->MP_APO_NRODOC;
        $_apoderadoVM->direccion = $_apoderado->MP_APO_DIRECCION;
        $_apoderadoVM->celular = $_apoderado->MP_APO_CELULAR;
        $_apoderadoVM->telefono = $_apoderado->MP_APO_TELEFONO;
        $_apoderadoVM->correo = $_apoderado->MP_APO_EMAIL;
        $_apoderadoVM->fecha_nacimiento = date('Y-m-d',strtotime($_apoderado->MP_APO_FECHANAC));
        $_apoderadoVM->genero = $_apoderado->MP_APO_SEXO;
        $_apoderadoVM->vive = $_apoderado->MP_APO_VIVE;
        $_apoderadoVM->estado_civil_id = $_apoderado->MP_EC_ID;
        $_apoderadoVM->religion_id = $_apoderado->MP_REL_ID;
        $_apoderadoVM->pais_nacimiento_id= $_apoderado->MP_PAIS_ID;
        $_apoderadoVM->pais_residencia_id= $_apoderado->MP_PAIS_DIR_ID;
        $_apoderadoVM->distrito_nacimiento_id= $_apoderado->MP_APO_UBIGNAC;
        $_apoderadoVM->distrito_residencia_id= $_apoderado->MP_APO_UBIGDIR;
        $_apoderadoVM->centro_laboral_id=$_apoderado->MP_CL_ID;
        $_apoderadoVM->ocupacion_id=$_apoderado->MP_OCU_ID;
        $_apoderadoVM->grado_instruccion_id=$_apoderado->MP_GI_ID;
        $_apoderadoVM->tipo_documento_id=$_apoderado->MP_TIPDOC_ID;
        $_apoderadoVM->parentesco_id=$_parentesco->MP_PAR_ID;
        $_apoderadoVM->tipo_parentesco_id=$_parentesco->MP_TIPAR_ID;
        $_apoderadoVM->alumno_id=$_parentesco->MP_ALU_ID;
        return $_apoderadoVM;
    }
    public function ListModelToViewModel($parentescos)
    {
        $_listApoderados = [];
        foreach ($parentescos as $parentesco) {
            array_push($_listApoderados, self::ModelToViewModel($parentesco, $parentesco->Apoderado));
        }
        return $_listApoderados;
    }
}
