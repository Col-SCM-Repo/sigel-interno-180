<?php

namespace App\Http\Controllers;

use App\Helpers\OrdenarArray;
use App\Structure\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    protected $ordenarArray;
    protected $_usuarioService;
    public function __construct(OrdenarArray $ordenarArray,
                                UsuarioService $_usuarioService)
    {
        $this->ordenarArray = $ordenarArray;
        $this->_usuarioService = $_usuarioService;
    }
    public function VistaIndex()
    {
        return view('modulos.pagosMatriculas.usuarios.index');
    }
    public function ObtenerUsuarios()
    {
        return response()->json($this->ordenarArray->AscendenteDosCampos($this->_usuarioService->ObtenerUsuarios(),'apellidos','nombres'));
    }
    public function ObtenerViewModel()
    {
        return response()->json($this->_usuarioService->ObtenerViewModel());
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_usuarioService->Guardar((object) $request->usuario));
    }
}
