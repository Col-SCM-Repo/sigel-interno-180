<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'MP_TIPODOC';
    protected $primaryKey = 'MP_TIPDOC_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_TIPDOC_ID',
        'MP_TIPDOC_NOMBRE'
    ];

    public function id()
    {
        return $this->MP_TIPDOC_ID;
    }
    public function nombre()
    {
        return $this->MP_TIPDOC_NOMBRE;
    }
}
