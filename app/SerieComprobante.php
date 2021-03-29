<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerieComprobante extends Model
{
    protected $table = 'MP_SERIECOMPROBANTE';
    protected $primaryKey = 'MP_SERCOM_ID';
    protected $fillable = [
        'MP_SERCOM_ID',
        'MP_SERCOM_NOMBRE',
        'USU_ID'
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
        return $this->hasMany('App\Pago', 'MP_SERCOM_ID', 'MP_SERCOM_ID');
    }
    public function serie()
    {
        return $this->MP_SERCOM_NOMBRE;
    }
    public function id()
    {
        return $this->MP_SERCOM_ID;
    }
}
