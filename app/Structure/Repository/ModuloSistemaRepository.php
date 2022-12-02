<?php
namespace App\Structure\Repository;

use App\ModuloSistema;
use Exception;

class ModuloSistemaRepository extends ModuloSistema
{
    public function ObtenerTodosModulos  () {
        return self::all();
    }

    public function BuscarModuloPorId( $modulo_sistema_id ){
        return self::find($modulo_sistema_id);
    }

    public function BuscarModuloPorNombre( $nombre_modulo ){
        return self::where("MP_NOMBRE_MODULO", 'like', "$nombre_modulo")->first();
    }

    public function Crear ( $moduloSistemaM ){
        $nuevoModulo = new ModuloSistema();
        $nuevoModulo = $moduloSistemaM;
        $nuevoModulo->save();
        return $nuevoModulo->id();
    }

    public function Actualizar ( $modulosSistemaM ){
        $moduloActualizar = ModuloSistema::find( $modulosSistemaM->id() );
        $moduloActualizar->MP_NOMBRE_MODULO = $moduloActualizar->MP_NOMBRE_MODULO;
        $moduloActualizar->MP_NOMBRE_SUBMODULO  = $moduloActualizar->MP_NOMBRE_SUBMODULO;
        $moduloActualizar->MP_OBSERVACIONES = $moduloActualizar->MP_OBSERVACIONES;
        $moduloActualizar->save();
        return $moduloActualizar->id();
    }

    public function Eliminar ( $modulo_sistema_id ){
        $moduloSistema  = self::find($modulo_sistema_id);
        if(!$moduloSistema) throw new Exception("Error, no se encontro el modulo de sistema con codigo $modulo_sistema_id .");
        $moduloSistema->delete();
        return true;
    }
}
