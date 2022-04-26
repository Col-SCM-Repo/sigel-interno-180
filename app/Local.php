<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'MP_LOCAL';
    protected $primaryKey = 'MP_LOC_ID';
    protected $fillable = [
        'MP_LOC_ID',
        'MP_LOC_NOM',
        'MP_LOC_DIR',
        'MP_LOC_OBS'
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
