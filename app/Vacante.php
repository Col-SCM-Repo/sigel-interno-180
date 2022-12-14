<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    protected $table = 'MP_VACANTES';
    protected $primaryKey = 'MP_VAC_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_VAC_ID',
        'MP_VAC_TOT',
        'MP_VAC_OCU',
        'MP_VAC_DISP',
        'MP_VAC_OBS',
        'MP_ANIO_ID',
        'MP_GRAD_ID',
        'MP_NIV_ID',
        'MP_LOC_ID',
        'MP_SEC_ID'];
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
      return $this->belongsTo('App\Grado', 'MP_GRAD_ID', 'MP_GRA_ID');
    }
    public function id()
    {
      return $this->MP_VAC_ID;
    }
    public function anioId()
    {
      return $this->MP_ANIO_ID;
    }
    public function total_vacantes()
    {
      return $this->MP_VAC_TOT;
    }
    public function vacantes_disponibles()
    {
      return $this->MP_VAC_DISP;
    }
    public function vacantes_ocupadas()
    {
      return $this->MP_VAC_OCU;
    }
}
