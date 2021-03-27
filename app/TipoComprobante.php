<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    protected $table = 'MP_TIPOCOMPROBANTE';
    protected $primaryKey = 'MP_TIPCOM_ID';
    protected $fillable = [
        'MP_TIPCOM_ID',
        'MP_TIPCOM_NOMBRE'
    ];
     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'created_at', 'updated_at'
    ];
    public function Pagos()
    {
        return $this->hasMany('App\Pago', 'MP_TIPCOM_ID', 'MP_TIPCOM_ID');
    }
    public function tipo()
    {
        return $this->MP_TIPCOM_NOMBRE;
    }
}
