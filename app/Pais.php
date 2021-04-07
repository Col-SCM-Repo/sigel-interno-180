<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'MP_PAIS';
    protected $primaryKey = 'MP_PAIS_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_PAIS_ID',
        'MP_PAIS_NOMBRE'
    ];

    public function id()
    {
        return $this->MP_PAIS_ID;
    }
    public function nombre()
    {
        return $this->MP_PAIS_NOMBRE;
    }
}
