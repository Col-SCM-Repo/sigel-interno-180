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
        'MP_REL_ID',
        'MP_ALU_UBIGDIR',
    ];
    public function Matriculas()
    {
        return $this->hasMany('App\Matricula', 'MP_ALU_ID', 'MP_ALU_ID');
    }
    public function Parentescos()
    {
        return $this->hasMany('App\Parentesco', 'MP_ALU_ID', 'MP_ALU_ID');
    }
    public function DistritoNacimiento()
    {
        return $this->belongsTo('App\Distrito', 'MP_ALU_UBIGNAC', 'MP_UBIG_ID');
    }
    //
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
    public function religion_id()
    {
        return $this->MP_REL_ID;
    }
}
