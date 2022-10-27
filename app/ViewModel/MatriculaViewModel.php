<?php
namespace App\ViewModel;

class MatriculaViewModel
{
        public $id = 0;
        public $fecha_matricula = '';
        public $fecha_ingreso = '';
        public $fecha_fin = null;
        public $pariente_id = '';
        public $pariente = '';
        public $tipo_matricula_id = '';
        public $observacion = '';
        public $usuario_id = '';
        public $institucion_educativa_procedencia_id = '';
        public $estado = 2;//ESTADO DE MATRICULA NORMAL
        public $alumno_id = '';
        public $alumno = '';
        public $situacion = 'PROMOVIDO';
        public $pago_observacion = '';
        public $vacante_id = '';
        public $vacante = '';
        public $nivel = '';
        public $grado = '';
        public $monto_matricula = '';
        public $monto_pension = '';
        public $nombres_alumno = '';
        public $cronogramas =[];
        public $frente_carnet = '';
        public $reverso_carnet = '';
        public $puede_retirarse = false;
        public $descuento_id = null;
}
