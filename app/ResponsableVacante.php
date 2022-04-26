<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponsableVacante extends Model
{
    protected $table = 'responsable_vacante';
    protected $primaryKey = 'id';
    protected $fillable = ['id',
        'codigo',
        'estado',
        'responsable_id',
        'vacante_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function NotasAcademicas()
    {
        return $this->hasMany('App\NotaAcademica', 'responsable_vacante_id', 'id');
    }
    public function Responsable()
    {
        return $this->belongsTo('App\Responsable', 'responsable_id', 'id');
    }
    public function Vacante()
    {
        return $this->belongsTo('App\Vacante', 'vacante_id', 'id');
    }
}
