<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    protected $table = 'MP_OCUPACION';
    protected $primaryKey = 'MP_OCU_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_OCU_ID',
        'MP_OCU_NOMBRE'
    ];
    public function id()
    {
        return $this->MP_OCU_ID;
    }
    public function nombre()
    {
        return $this->MP_OCU_NOMBRE;
    }
}
