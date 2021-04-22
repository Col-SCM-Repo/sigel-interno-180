<?php
namespace App\ViewModel;

class AlumnoViewModel
{
    public $id =0;
    public $apellidos = '';
    public $nombres= '';
    public $dni= '';
    public $direccion = '';
    public $telefono = '';
    public $celular= '';
    public $correo= '';
    public $genero= '';
    public $fecha_nacimiento = '';
    public $pais_id = '';
    public $pais;
    public $distrito_nacimiento = '';
    public $religion_id = 1;
    public $religion;
    public $distrito_residencia = '';
    public $apoderados = [];
}
