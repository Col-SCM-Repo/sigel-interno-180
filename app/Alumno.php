<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'MP_ALUMNO';
    protected $primaryKey = 'MP_ALU_ID';
    protected $fillable = [
        'MP_ALU_ID',
        'MP_ALU_APELLIDOS',
        'MP_ALU_NOMBRES',
        'MP_ALU_DNI'
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
}
