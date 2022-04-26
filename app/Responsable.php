<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsables';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'ruta_registro', 'empleado_id','curso_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function Responsable_Vacantes()
    {
        return $this->hasMany('App\ResponsableVacante', 'responsable_id', 'id');
    }
    public function Curso()
    {
        return $this->belongsTo('App\Curso', 'curso_id', 'id');
    }
    public function Empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id', 'id');
    }
}
