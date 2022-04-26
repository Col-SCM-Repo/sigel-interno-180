<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoIntitucionEducativa extends Model
{
  protected $table = 'MP_TIPOIEPRO';
  protected $primaryKey = 'MP_TIPOIEPRO_ID';
  public $timestamps = false;
  protected $fillable = ['MP_TIPOIEPRO_ID', 'MP_TIPOIEPRO_NOMBRE', 'MP_TIPOIEPRO_DESCRIPCION'];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */

  public function InstitucionesEducativas()
  {
    return $this->hasMany('App\InstitucionEducativa', 'MP_TIPOIEPRO_ID', 'MP_TIPOIEPRO_ID');
  }
  public function id()
  {
      return $this->MP_TIPAR_ID;
  }
  public function nombre()
  {
      return $this->MP_TIPAR_NOMBRE;
  }
}
