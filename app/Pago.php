<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'MP_PAGO';
    protected $primaryKey = 'MP_PAGO_ID';
    protected $fillable = [
        'MP_PAGO_ID',
        'MP_MAT_ID',
        'MP_CRO_ID',
        'MP_CONPAGO_ID',
        'MP_SERCOM_ID'
    ];
     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'created_at', 'updated_at'
    ];
    public function Matricula()
    {
      return $this->belongsTo('App\Matricula', 'MP_MAT_ID', 'MP_MAT_ID');
    }
    public function CronogramaPago()
    {
      return $this->belongsTo('App\CronogramaPago','MP_CRO_ID','MP_CRO_ID');
    }
    public function ConceptoPago()
    {
      return $this->belongsTo('App\ConceptoPago', 'MP_CONPAGO_ID','MP_CONPAGO_ID');
    }
    public function SerieComprobante()
    {
      return $this->belongsTo('App\SerieComprobante', 'MP_SERCOM_ID','MP_SERCOM_ID');
    }
    public function TipoComprobante()
    {
      return $this->belongsTo('App\TipoComprobante', 'MP_TIPCOM_ID','MP_TIPCOM_ID');
    }
}
