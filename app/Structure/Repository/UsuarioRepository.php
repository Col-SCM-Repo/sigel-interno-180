<?php
namespace App\Structure\Repository;

use App\User;

class UsuarioRepository extends User
{
    public function ObtenerTodos()
    {
        return $this::all();
    }

    public function Crear($_usuarioM)
    {
        $nuevoUsuario = new User();
        $nuevoUsuario->USU_APELLIDOS =$_usuarioM->USU_APELLIDOS;
        $nuevoUsuario->USU_NOMBRES =$_usuarioM->USU_NOMBRES;
        $nuevoUsuario->username =$_usuarioM->username;
        $nuevoUsuario->USU_CARGO =$_usuarioM->USU_CARGO;
        $nuevoUsuario->USU_TIPO =$_usuarioM->USU_TIPO;
        $nuevoUsuario->USU_ESTADO =$_usuarioM->USU_ESTADO;
        $nuevoUsuario->password = $_usuarioM->password;
        $nuevoUsuario->save();
        return $nuevoUsuario->id();
    }
    public function Actualizar($_usuarioM)
    {
        $actualizarUsuario = User::find($_usuarioM->id());
        $actualizarUsuario->USU_APELLIDOS =$_usuarioM->USU_APELLIDOS;
        $actualizarUsuario->USU_NOMBRES =$_usuarioM->USU_NOMBRES;
        $actualizarUsuario->username =$_usuarioM->username;
        $actualizarUsuario->USU_CARGO =$_usuarioM->USU_CARGO;
        $actualizarUsuario->USU_TIPO =$_usuarioM->USU_TIPO;
        $actualizarUsuario->USU_ESTADO =$_usuarioM->USU_ESTADO;
        if($_usuarioM->password!=null){
            $actualizarUsuario->password = $_usuarioM->password;
        }
        $actualizarUsuario->save();
        return $actualizarUsuario->id();
    }
}
