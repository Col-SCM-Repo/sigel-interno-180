<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->estado()=='ACTIVO') {
            return redirect('alumnos');
        }else{
            Auth::logout();
            return redirect('/login');
        }
    }

    // public function mostarUsaurios()
    // {
    //     $usuarios = User::all();
    //     $cant=0;
    //     foreach ($usuarios as $usuario) {
    //         $usuario->password = bcrypt($usuario->USU_CONTRASENIA);
    //         $usuario->save();
    //     }
    //     return view('welcome')->with('cant', $cant);
    // }
}
