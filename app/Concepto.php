<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $table = 'MP_CONCEPTO';
    protected $primaryKey = 'MP_CON_ID';
    protected $fillable = ['MP_CON_ID',
                            'MP_CON_CONCEPTO',
                          ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
                            'created_at', 'updated_at'
                        ];
    public function ConceptosPago()
    {
        return $this->hasMany('App\ConceptoPago','MP_CON_ID','MP_CON_ID');
    }
}
