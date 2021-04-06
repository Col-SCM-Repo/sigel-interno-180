<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoParentesco extends Model
{
  protected $table = 'MP_TIPOPARENTESCO';
  protected $primaryKey = 'MP_TIPAR_ID';
  protected $fillable = ['MP_TIPAR_ID', 'MP_TIPAR_NOMBRE'];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'created_at', 'updated_at', 'deleted_at'
  ];
  public function Parentescos()
  {
    return $this->hasMany('App\Parentescos', 'tipo_parentesco_id', 'id');
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
