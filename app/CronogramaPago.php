<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramaPago extends Model
{
    protected $table = 'MP_CRONOGRAMAPAGO';
    protected $primaryKey = 'MP_CRO_ID';
    protected $fillable = [
        'MP_CRO_ID',
        'MP_CONPAGO_ID',
        'MP_MAT_ID'
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
      return $this->belongsTo('App\Matricula', 'MP_MAT_ID','MP_MAT_ID');
    }
    public function ConceptoPago()
    {
      return $this->belongsTo('App\ConceptoPago', 'MP_CONPAGO_ID','MP_CONPAGO_ID');
    }
    public function Pagos()
    {
      return $this->hasMany('App\Pago', 'MP_CRO_ID','MP_CRO_ID');
    }
}
