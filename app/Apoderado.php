<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
  protected $table = 'MP_APODERADO';
  protected $primaryKey = 'MP_APO_ID';
  public $timestamps = false;

  protected $fillable = ['MP_APO_ID',
        'MP_APO_NOMBRES',
        'MP_APO_APELLIDOS',
        'MP_APO_NRODOC',
        'MP_APO_DIRECCION',
        'MP_APO_CELULAR',
        'MP_APO_EMAIL',
        'MP_APO_FECHANAC',
        'MP_APO_SEXO',
        'MP_APO_VIVE',
        'MP_EC_ID',
        'MP_REL_ID',
        'MP_PAIS_ID',
        'MP_PAIS_DIR_ID',
        'MP_APO_UBIGDIR',
        'MP_APO_UBIGNAC',
        'MP_CL_ID',
        'MP_OCU_ID',
        'MP_GI_ID',
        'MP_TIPDOC_ID',
        'MP_APO_TELEFONO'];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'created_at', 'updated_at', 'deleted_at'
  ];
  public function id()
  {
      return $this->MP_APO_ID;
  }
  public function nombres()
  {
      return $this->MP_APO_NOMBRES;
  }
  public function apellidos()
  {
      return $this->MP_APO_APELLIDOS;
  }
  public function dni()
  {
      return $this->MP_APO_NRODOC;
  }
  public function telefono()
  {
      return $this->MP_APO_TELEFONO;
  }
  public function celular()
  {
      return $this->MP_APO_CELULAR;
  }
  public function direccion()
  {
      return $this->MP_APO_DIRECCION;
  }
  public function correo()
  {
      return $this->MP_APO_EMAIL;
  }
  public function fecha_nacimineto()
  {
      return $this->MP_APO_FECHANAC;
  }
  public function genero()
  {
      return $this->MP_APO_SEXO;
  }
  public function vive()
  {
      return $this->MP_APO_VIVE;
  }
  public function estado_civil_id()
  {
      return $this->MP_EC_ID;
  }
  public function religion_id()
  {
      return $this->MP_REL_ID;
  }
  public function pais_residencia_id()
  {
      return $this->MP_PAIS_DIR_ID;
  }
  public function pais_nacimiento_id()
  {
      return $this->MP_PAIS_ID;
  }
  public function distrito_residencia_id()
  {
      return $this->MP_APO_UBIGDIR;
  }
  public function distrito_nacimiento_id()
  {
      return $this->MP_APO_UBIGNAC;
  }
  public function centro_laboral_id()
  {
      return $this->MP_CL_ID;
  }
  public function ocupacion_id()
  {
      return $this->MP_OCU_ID;
  }
  public function grado_intruccion_id()
  {
      return $this->MP_GI_ID;
  }
  public function tipo_documento_id()
  {
      return $this->MP_TIPDOC_ID;
  }
}
