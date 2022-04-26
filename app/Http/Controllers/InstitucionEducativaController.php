<?php

namespace App\Http\Controllers;

use App\Structure\Services\DistritoService;
use App\Structure\Services\InstitucionEducativaService;
use App\Structure\Services\PaisService;
use App\Structure\Services\TipoInstitucionEducativaService;
use Illuminate\Http\Request;

class InstitucionEducativaController extends Controller
{
    protected $_institucionEducativaService;
    protected $_paisService;
    protected $_distritoService;
    protected $_tipoInstitucionEducativaService;
    public function __construct(InstitucionEducativaService $_institucionEducativaService,
                                PaisService $_paisService,
                                DistritoService $_distritoService,
                                TipoInstitucionEducativaService $_tipoInstitucionEducativaService)
    {
        $this->_institucionEducativaService = $_institucionEducativaService;
        $this->_paisService = $_paisService;
        $this->_distritoService = $_distritoService;
        $this->_tipoInstitucionEducativaService = $_tipoInstitucionEducativaService;
    }
    public function ObtenerInstituciones()
    {
        return response()->json($this->_institucionEducativaService->ObtenerTodas());
    }
    public function ObtenerDatos()
    {
        $data = [
            'modelo'=> $this->_institucionEducativaService->CrearViewModel(),
            'paises'=> $this->_paisService->ObtenerPaises(),
            'tipos'=> $this->_tipoInstitucionEducativaService->ObtenerTiposInstitucionEducativa(),
            'distritos'=> $this->_distritoService->ObtenerDistritos(),
        ];
        return response()->json($data);
    }
    public function Guardar(Request $request)
    {
        return response()->json($this->_institucionEducativaService->Guardar((object)$request->institucion));
    }
}
