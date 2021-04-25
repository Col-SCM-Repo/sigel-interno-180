<?php

namespace App\Http\Controllers;

use App\InstitucionEducativa;
use App\Structure\Services\InstitucionEducativaService;

class InstitucionEducativaController extends Controller
{
    protected $_institucionEducativaservice;
    public function __construct(InstitucionEducativaService $_institucionEducativaservice)
    {
        $this->_institucionEducativaservice = $_institucionEducativaservice;
    }
    public function ObtenerInstituciones()
    {
        return response()->json($this->_institucionEducativaservice->ObtenerTodas());
    }
}
