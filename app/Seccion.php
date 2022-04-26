<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = 'MP_SECCION';
    protected $primaryKey = 'MP_SEC_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_SEC_ID',
        'MP_SEC_NOMBRE'
    ];
    public function seccion()
    {
        return $this->MP_SEC_NOMBRE;
    }
}
