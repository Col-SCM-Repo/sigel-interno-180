<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'MP_MATRICULA';
    protected $primaryKey = 'MP_MAT_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_MAT_ID',
        'MP_MAT_FECHAMATRICULA',
        'MP_VAC_ID',
        'MP_MAT_ESTADO',
        'MP_ALU_ID',
        'MP_PAR_ID',
        'MP_MAT_FECHAMATRICULA',
        'MP_MAT_OBS',
        'MP_TIPMAT_ID',
        'MP_IEPRO_ID',
        'MP_PAG_OBS',
        'USU_ID',
        'MP_MAT_SITUACION'
    ];

    public function Vacante()
    {
        return $this->belongsTo('App\Vacante', 'MP_VAC_ID', 'MP_VAC_ID');
    }
    public function Notas()
    {
        return $this->hasMany('App\NotaAcademica', 'matricula_id', 'MP_MAT_ID');
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
    public function Patentesco()
    {
        return $this->belongsTo('App\Parentesco', 'MP_PAR_ID', 'MP_PAR_ID');
    }
    public function IEProcedencia()
    {
        return $this->belongsTo('App\InstitucionEducativa', 'MP_IEPRO_ID', 'MP_IEPRO_ID');
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
    public function pariente_id()
    {
        return $this->MP_PAR_ID;
    }
    public function alumno_id()
    {
        return $this->MP_ALU_ID;
    }
    public function fecha()
    {
        return $this->MP_MAT_FECHAMATRICULA;
    }
    public function tipo_id()
    {
        return $this->MP_TIPMAT_ID;
    }
    public function observacion()
    {
        return $this->MP_MAT_OBS;
    }
    public function ie_procedencia_id()
    {
        return $this->MP_IEPRO_ID;
    }
    public function vacante_id()
    {
        return $this->MP_VAC_ID;
    }
}
