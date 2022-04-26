<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carnet extends Model
{
    protected $table = 'carnet';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'path',
        'parte',
        'anio_id',
        'nivel_id',
        'local_id'
    ];
    public function Local()
    {
        return $this->belongsTo('App\Local', 'local_id', 'MP_LOC_ID');
    }
    public function Nivel()
    {
        return $this->belongsTo('App\Nivel', 'nivel_id', 'MP_NIV_ID');
    }
    public function Anio()
    {
        return $this->belongsTo('App\AnioAcademico', 'anio_id', 'MP_ANIO_ID');
    }
    public function id()
    {
        return $this->id;
    }
}
