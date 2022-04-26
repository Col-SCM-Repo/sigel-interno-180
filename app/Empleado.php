<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id';
    protected $fillable = ['id',
        'apellidos',
        'nombres',
        'foto',
        'genero',
        'documento',
        'tipo_documento',
        'user_id',
        'especialidad_id'];

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
        return $this->hasMany('App\Responsable', 'empleado_id', 'id');
    }

}
