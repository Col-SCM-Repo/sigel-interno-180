<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConceptoPago extends Model
{
    protected $table = 'MP_CONCEPTOPAGO';
    protected $primaryKey = 'MP_CONPAGO_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_CONPAGO_ID',
        'MP_CONPAGO_MONTO',
        'MP_CON_ID',
        'MP_ANIO_ID',
        'FECHA_VENCIMIENTO',
        'MP_NIV_ID',
        'MP_LOC_ID'
    ];

    public function CronogramasPago()
    {
        return $this->hasMany('App\CronogramaPago','MP_CONPAGO_ID','MP_CONPAGO_ID');
    }
    public function Concepto()
    {
      return $this->belongsTo('App\Concepto', 'MP_CON_ID','MP_CON_ID');
    }
    public function AnioAcademico()
    {
      return $this->belongsTo('App\AnioAcademico', 'MP_ANIO_ID','MP_ANIO_ID');
    }
    public function id()
    {
        return $this->MP_CONPAGO_ID;
    }
    public function monto()
    {
        return $this->MP_CONPAGO_MONTO;
    }
    public function fecha_vencimiento()
    {
        return $this->FECHA_VENCIMIENTO;
    }
    public function concepto_id()
    {
        return $this->MP_CON_ID;
    }
}
