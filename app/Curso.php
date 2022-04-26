<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'id';
    protected $fillable = ['id',
        'curso',
        'icono',
        'color',
        'estado',
        'area_academica_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function Responsables()
    {
        return $this->hasMany('App\Responsable');
    }
    public function AreaAcademica()
    {
        return $this->belongsTo('App\AreaAcademica', 'area_academica_id', 'id');
    }
    // public function grados()
    // {
    //   return $this->belongsToMany('App\Grados', 'grado_curso', 'curso_id', 'grado_id')
    //             ->as('grado_curso')
    //             ->withPivot('id', 'estado');
    // }
}

