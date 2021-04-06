<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $table = 'MP_RELIGION';
    protected $primaryKey = 'MP_REL_ID';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'MP_REL_ID',
        'MP_REL_NOMBRE'
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
        return $this->MP_REL_ID;
    }
    public function religion()
    {
        return $this->MP_REL_NOMBRE;
    }
}
