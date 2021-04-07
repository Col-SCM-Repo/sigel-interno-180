<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradoInstruccion extends Model
{
    protected $table = 'MP_GRADOINSTRUCCION';
    protected $primaryKey = 'MP_GI_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_GI_ID',
        'MP_GI_NOMBRE'
    ];
    public function id()
    {
        return $this->MP_GI_ID;
    }
    public function nombre()
    {
        return $this->MP_GI_NOMBRE;
    }
}
