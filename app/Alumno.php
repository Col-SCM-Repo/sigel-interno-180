<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'MP_ALUMNO';
    protected $primaryKey = 'MP_ALU_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_ALU_ID',
        'MP_ALU_APELLIDOS',
        'MP_ALU_NOMBRES',
        'MP_ALU_DNI',
        'MP_ALU_DIRECCION',
        'MP_ALU_TELEFONO',
        'MP_ALU_CELULAR',
        'MP_ALU_EMAIL',
        'MP_ALU_SEXO',
        'MP_ALU_FECHANAC',
        'MP_PAIS_ID',
        'MP_ALU_UBIGNAC',
        'MP_ALU_UBIGDIR',
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function Matriculas()
    {
        return $this->hasMany('App\Matricula', 'MP_ALU_ID', 'MP_ALU_ID');
    }


    // public function Parentescos()
    // {
    //     return $this->hasMany('App\Parentescos', 'alumno_id', 'id');
    // }
    public function nombres()
    {
        return $this->MP_ALU_NOMBRES;
    }
    public function apellidos()
    {
        return $this->MP_ALU_APELLIDOS;
    }
    public function id()
    {
        return $this->MP_ALU_ID;
    }
    public function dni()
    {
        return $this->MP_ALU_DNI;
    }
    public function direccion()
    {
        return $this->MP_ALU_DIRECCION;
    }
    public function celular()
    {
        return $this->MP_ALU_CELULAR;
    }
    public function telefono()
    {
        return $this->MP_ALU_TELEFONO;
    }
    public function correo()
    {
        return $this->MP_ALU_EMAIL;
    }
    public function genero()
    {
        return $this->MP_ALU_SEXO;
    }
    public function fecha_nacimiento()
    {
        return $this->MP_ALU_FECHANAC;
    }
    public function pais_id()
    {
        return $this->MP_PAIS_ID;
    }
    public function distrito_nacimiento()
    {
        return $this->MP_ALU_UBIGNAC;
    }
    public function distrito_residencia()
    {
        return $this->MP_ALU_UBIGDIR;
    }
}

