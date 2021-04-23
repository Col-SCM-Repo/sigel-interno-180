<?php
namespace App\Mappers;

use App\Apoderado;
use App\Parentesco;
use App\ViewModel\ApoderadoViewModel;

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
    public function ViewModel()
    {
        return new ApoderadoViewModel();
    }
    public function ViewModelToModel($_apoderadoViewModel)
    {
        $_apoderadoModel = new Apoderado();
        $_parentescoModel = new Parentesco();

        if ($_apoderadoViewModel->id != 0) {
            $_apoderadoModel->MP_APO_ID =$_apoderadoViewModel->id;
        }

        $_apoderadoModel->MP_APO_NOMBRES = mb_strtoupper($_apoderadoViewModel->nombres) ;
        $_apoderadoModel->MP_APO_APELLIDOS = mb_strtoupper($_apoderadoViewModel->apellidos) ;
        $_apoderadoModel->MP_APO_NRODOC = $_apoderadoViewModel->dni ;
        $_apoderadoModel->MP_APO_DIRECCION = mb_strtoupper($_apoderadoViewModel->direccion) ;
        $_apoderadoModel->MP_APO_CELULAR = $_apoderadoViewModel->celular ;
        $_apoderadoModel->MP_APO_TELEFONO = $_apoderadoViewModel->telefono ;
        $_apoderadoModel->MP_APO_EMAIL = $_apoderadoViewModel->correo ;
        $_apoderadoModel->MP_APO_FECHANAC = date('Y-m-d\TH:i:s',strtotime($_apoderadoViewModel->fecha_nacimiento));
        $_apoderadoModel->MP_APO_SEXO = $_apoderadoViewModel->genero ;
        $_apoderadoModel->MP_APO_VIVE = $_apoderadoViewModel->vive ;
        $_apoderadoModel->MP_EC_ID = $_apoderadoViewModel->estado_civil_id ;
        $_apoderadoModel->MP_REL_ID = $_apoderadoViewModel->religion_id ;
        $_apoderadoModel->MP_PAIS_ID = $_apoderadoViewModel->pais_nacimiento_id;
        $_apoderadoModel->MP_PAIS_DIR_ID = $_apoderadoViewModel->pais_residencia_id ;
        $_apoderadoModel->MP_APO_UBIGNAC = $_apoderadoViewModel->distrito_nacimiento_id;
        $_apoderadoModel->MP_APO_UBIGDIR = $_apoderadoViewModel->distrito_residencia_id;
        $_apoderadoModel->MP_CL_ID = $_apoderadoViewModel->centro_laboral_id;
        $_apoderadoModel->MP_OCU_ID = $_apoderadoViewModel->ocupacion_id;
        $_apoderadoModel->MP_GI_ID= $_apoderadoViewModel->grado_instruccion_id;
        $_apoderadoModel->MP_TIPDOC_ID = $_apoderadoViewModel->tipo_documento_id;

        if ($_apoderadoViewModel->parentesco_id != 0) {
            $_parentescoModel->MP_PAR_ID = $_apoderadoViewModel->parentesco_id;
        }
        $_parentescoModel->MP_TIPAR_ID = $_apoderadoViewModel->tipo_parentesco_id;
        $_parentescoModel->MP_ALU_ID = $_apoderadoViewModel->alumno_id;

        return (object)[
            'apoderadoModel'=> $_apoderadoModel,
            'parentesModel'=> $_parentescoModel,
        ];
    }
}
