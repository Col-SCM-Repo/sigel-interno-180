<?php
namespace App\Structure\Repository;

use App\Parentesco;

class ParentescoRepositoy extends Parentesco
{
    public function BuscarPorAlumnoId($alumno_id)
    {
        return $this::where('MP_ALU_ID',$alumno_id)->get();
    }
    public function Actualizar($parentescoModel)
    {
        $actualizarParentesco = Parentesco::find($parentescoModel->id());
        $actualizarParentesco->MP_ALU_ID = $parentescoModel->MP_ALU_ID;
        $actualizarParentesco->MP_APO_ID = $parentescoModel->MP_APO_ID;
        $actualizarParentesco->MP_TIPAR_ID = $parentescoModel->MP_TIPAR_ID;
        $actualizarParentesco->MP_RESPONSABLE_PAGO_DEFECTO = $parentescoModel->MP_RESPONSABLE_PAGO_DEFECTO;
        $actualizarParentesco->save();
        return $actualizarParentesco->id();
    }
    public function Crear($parentescoM)
    {
        $nuevoParentesco = new Parentesco();
        $nuevoParentesco = $parentescoM;
        $nuevoParentesco->save();
        return $nuevoParentesco->id();
    }
    public function BuscarPorId($_parentescoId)
    {
        return $this::find($_parentescoId);
    }
    public function BuscarPorAlumnoIdYTipoParentesco( $alumno_id, $_tipo_parentesco_id)
    {
        return $this::where('MP_TIPAR_ID', $_tipo_parentesco_id)
                    ->where('MP_ALU_ID', $alumno_id)
                    ->first();
    }
    public function ResponsableMatricula ($alumno_id){
        $responsable =   $this::where('MP_RESPONSABLE_PAGO_DEFECTO', 1)
                    ->where('MP_ALU_ID', $alumno_id)
                    ->first();
        if(!$responsable)
            $responsable = $this::where('MP_ALU_ID', $alumno_id)->first();
        return $responsable;
    }
}
