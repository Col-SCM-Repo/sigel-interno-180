<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'MP_NIVEL';
    protected $primaryKey = 'MP_NIV_ID';
    protected $fillable = [
        'MP_NIV_ID',
        'MP_NIV_NIVEL'
    ];

    public function nivel()
    {
        return $this->MP_NIV_NIVEL;
    }
    public function id()
    {
        return $this->MP_NIV_ID;
    }
}
