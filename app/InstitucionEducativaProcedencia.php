<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitucionEducativaProcedencia extends Model
{
    protected $table = 'MP_IEPROCEDENCIA';
    protected $primaryKey = 'MP_IEPRO_ID';
    protected $fillable = [
        'MP_IEPRO_ID',
        'MP_IEPRO_NOMBRE',
        'MP_IEPRO_REFERENCIA'
    ];

    public function nombre()
    {
        return $this->MP_IEPRO_NOMBRE;
    }
    public function id()
    {
        return $this->MP_IEPRO_ID;
    }
    public function referencia()
    {
        return $this->MP_IEPRO_REFERENCIA;
    }
}
