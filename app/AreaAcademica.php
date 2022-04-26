<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaAcademica extends Model
{
    protected $table = 'area_academica';
    protected $primaryKey = 'id';
    protected $fillable = ['id',
        'area',
        'estado'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function Cursos()
    {
        return $this->hasMany('App\Curso');
    }

    // public function grados()
    // {
    //   return $this->belongsToMany('App\Grados', 'grado_curso', 'curso_id', 'grado_id')
    //             ->as('grado_curso')
    //             ->withPivot('id', 'estado');
    // }
}

