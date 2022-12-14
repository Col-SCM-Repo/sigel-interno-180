<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
  protected $table = 'MP_PARENTESCO';
  protected $primaryKey = 'MP_PAR_ID';
    public $timestamps = false;

    protected $fillable = ['MP_PAR_ID',
        'MP_ALU_ID',
        'MP_APO_ID',
        'MP_TIPAR_ID'];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'created_at', 'updated_at', 'deleted_at'
  ];
  public function Alumno()
  {
    return $this->belongsTo('App\Alumno', 'MP_ALU_ID', 'MP_ALU_ID');
  }
  public function Apoderado()
  {
    return $this->belongsTo('App\Apoderado', 'MP_APO_ID', 'MP_APO_ID');
  }
  public function TipoParentesco()
  {
    return $this->belongsTo('App\TipoParentesco', 'MP_TIPAR_ID', 'MP_TIPAR_ID');
  }

    public function id()
    {
        return $this->MP_PAR_ID;
    }
    public function tipo_id()
    {
        return $this->MP_TIPAR_ID;
    }
}
