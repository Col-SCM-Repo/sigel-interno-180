<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'MP_UBIGEO';
    protected $primaryKey = 'MP_UBIG_ID';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'MP_UBIG_ID',
        'MP_UBIG_REGION',
        'MP_UBIG_PROVINCIA',
        'MP_UBIG_DISTRITO'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    public function id()
    {
        return $this->MP_UBIG_ID;
    }
    public function region()
    {
        return $this->MP_UBIG_REGION;
    }
    public function provincia()
    {
        return $this->MP_UBIG_PROVINCIA;
    }
    public function distrito()
    {
        return $this->MP_UBIG_DISTRITO;
    }
}
