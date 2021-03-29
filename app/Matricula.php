<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'MP_MATRICULA';
    protected $primaryKey = 'MP_MAT_ID';
    protected $fillable = [
        'MP_MAT_ID',
        'MP_MAT_FECHAMATRICULA',
        'MP_VAC_ID',
        'MP_MAT_ESTADO',
        'MP_ALU_ID'
    ];

    public function Vacante()
    {
        return $this->belongsTo('App\Vacante', 'MP_VAC_ID', 'MP_VAC_ID');
    }

    public function Alumno()
    {
        return $this->belongsTo('App\Alumno', 'MP_ALU_ID', 'MP_ALU_ID');
    }

    public function CronogramaPagos()
    {
        return $this->hasMany('App\CronogramaPago', 'MP_MAT_ID', 'MP_MAT_ID');
    }

    public function Pagos()
    {
        return $this->hasMany('App\Pago', 'MP_MAT_ID', 'MP_MAT_ID');
    }

    public function Usuario()
    {
        return $this->belongsTo('App\User', 'USU_ID', 'USU_ID');
    }
    //campos de manera resumida
    public function estado()
    {
        return $this->MP_MAT_ESTADO;
    }
    public function id()
    {
        return $this->MP_MAT_ID;
    }
}
