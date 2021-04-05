<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'MP_PAIS';
    protected $primaryKey = 'MP_PAIS_ID';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'MP_PAIS_ID',
        'MP_PAIS_NOMBRE'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
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
