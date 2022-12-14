<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    protected $table = 'MP_GRADO';
    protected $primaryKey = 'MP_GRA_ID';
    protected $fillable = [
        'MP_GRA_ID',
        'MP_GRA_GRADO'
    ];
    public function grado()
    {
        return $this->MP_GRA_GRADO;
    }
    public function id()
    {
        return $this->MP_GRA_ID;
    }
}
