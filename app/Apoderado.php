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
        'MP_APO_TELEFONO'];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'created_at', 'updated_at', 'deleted_at'
  ];
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
}
