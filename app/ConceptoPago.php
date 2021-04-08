<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConceptoPago extends Model
{
    protected $table = 'MP_CONCEPTOPAGO';
    protected $primaryKey = 'MP_CONPAGO_ID';
    protected $fillable = [
        'MP_CONPAGO_ID',
        'MP_CONPAGO_MONTO',
        'MP_CON_ID',
        'MP_ANIO_ID'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
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
}
