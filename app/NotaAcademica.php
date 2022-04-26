<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaAcademica extends Model
{
    protected $table = 'nota_academica';
    protected $primaryKey = 'id';
    protected $fillable = ['id',
        'codigo',
        'exonerado',
        'resolucion_directorial_exo',
        'u1n1', 'u1n2',
        'u1n3', 'u1n4',
        'u1n5', 'u1n6',
        'pu1', 'u2n1',
        'u2n2', 'u2n3',
        'u2n4', 'u2n5',
        'u2n6', 'pu2',
        'u3n1', 'u3n2',
        'u3n3', 'u3n4',
        'u3n5', 'u3n6',
        'pu3', 'u4n1',
        'u4n2', 'u4n3',
        'u4n4', 'u4n5',
        'u4n6', 'pu4',
        'ptn', 'ptc',
        'puntaje',
        'merito',
        'matricula_id',
        'empleado_curso_seccion_id',
        'periodo_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function ResponsableVacante()
    {
        return $this->belongsTo('App\ResponsableVacante', 'responsable_vacante_id', 'id');
    }
}
