<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnioAcademico extends Model
{
    protected $table = 'MP_ANIOACADEMICO';
    protected $primaryKey = 'MP_ANIO_ID';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'MP_ANIO_ID',
        'MP_ANIO_FECHAINICIO',
        'MP_ANIO_DESCRIPCION',
        'MP_ANIO_NOMBRE',
        'MP_ANIO_ESTADO',
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
        return $this->MP_ANIO_ID;
    }
    public function nombre()
    {
        return $this->MP_ANIO_NOMBRE;
    }
    public function estado()
    {
        return $this->MP_ANIO_ESTADO;
    }
    public function Vacantes()
    {
        return $this->hasMany('App\Vacante', 'MP_ANIO_ID', 'MP_ANIO_ID');
    }
}
