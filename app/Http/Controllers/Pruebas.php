<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class Pruebas extends Controller
{
    public function ObtenerUsuarios()
    {
        $usuarios = User::all();
        $cant = 0;
        foreach($usuarios as $usuario){
            $usuario->username= $usuario->USU_USUARIO;
            $usuario->password= bcrypt($usuario->USU_CONTRASENIA);
            $usuario->save();
            $cant++;
        }
        return view('pruebas')->with('cant', $cant);

    }
}
