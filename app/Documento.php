<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'MP_DOCUMENTOS';
    protected $primaryKey = 'MP_DOCUMENTOS_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_DOCUMENTOS_ID',
        'MP_DIRECTORIO_ARCHIVO',
        'MP_NOMBRE_ARCHIVO',
        'USU_ID',
        'MP_MODULOS_SISTEMA_ID'
    ];

    protected $hidden = [
    ];

    public function id()
    {
        return $this->MP_DOCUMENTOS_ID;
    }

    public function directorio()
    {
        return $this->MP_DIRECTORIO_ARCHIVO;
    }

    public function nombreArchivo()
    {
        return $this->MP_NOMBRE_ARCHIVO;
    }

    public function usuario (){
        return $this->belongsTo(User::class, 'USU_ID', 'USU_ID');
    }

    public function moduloSistema()
    {
        return $this->belongsTo(ModuloSistema::class, 'MP_MODULOS_SISTEMA_ID', 'MP_MODULOS_SISTEMA_ID');
    }
}
