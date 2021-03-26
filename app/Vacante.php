<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    protected $table = 'MP_VACANTES';
    protected $primaryKey = 'MP_VAC_ID';
    protected $fillable = ['MP_VAC_ID',
        'MP_ANIO_ID'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    // public function Responsable_Vacantes()
    // {
    //   return $this->hasMany('App\ResponsableVacante', 'vacante_id', 'id');
    // }

    public function AnioAcademico()
    {
      return $this->belongsTo('App\AnioAcademico', 'MP_ANIO_ID', 'MP_ANIO_ID');
    }
    public function Matriculas()
    {
        return $this->hasMany('App\Matricula', 'MP_VAC_ID', 'MP_VAC_ID');
    }
    public function Nivel()
    {
      return $this->belongsTo('App\Nivel', 'MP_NIV_ID', 'MP_NIV_ID');
    }
    public function Seccion()
    {
      return $this->belongsTo('App\Seccion', 'MP_SEC_ID', 'MP_SEC_ID');
    }
    public function Grado()
    {
      return $this->belongsTo('App\Grado', 'MP_GRA_ID', 'MP_GRA_ID');
    }
    // public function Local()
    // {
    //   return $this->belongsTo('App\Local', 'local_id', 'id');
    // }
}
