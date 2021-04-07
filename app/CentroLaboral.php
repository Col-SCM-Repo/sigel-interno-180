<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroLaboral extends Model
{
    protected $table = 'MP_CENTROLABORAL';
    protected $primaryKey = 'MP_CL_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_CL_ID',
        'MP_CL_NOMBRE'
    ];
    public function id()
    {
        return $this->MP_CL_ID;
    }
    public function nombre()
    {
        return $this->MP_CL_NOMBRE;
    }
}
