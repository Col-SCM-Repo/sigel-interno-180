<?php
namespace App\Structure\Services;

use App\Mappers\UsuarioMapper;
use App\Structure\Repository\UsuarioRepository;

class UsuarioService
{
    protected $_usuarioMapper;
    protected $_usuarioRepository;
    protected $_serieService;
    public function __construct()
    {
       $this->_usuarioMapper = new UsuarioMapper();
       $this->_usuarioRepository = new UsuarioRepository();
       $this->_serieService = new SerieService();
    }
    public function ObtenerUsuarios()
    {
        $_listaUsauriosVM = $this->_usuarioMapper->ListModelToViewModel($this->_usuarioRepository->ObtenerTodos());
        foreach ($_listaUsauriosVM as $usuarioVM) {
            $usuarioVM->serie = $this->_serieService->BuscarPorUsuario($usuarioVM->id);
        }
        return $_listaUsauriosVM;
    }
    public function ObtenerViewModel()
    {
        return $this->_usuarioMapper->ViewModel();
    }
    public function Guardar($usuarioVM)
    {
        $_usuarioModel = $this->_usuarioMapper->ViewModelToModel($usuarioVM);
        if ($usuarioVM->id!=0) {
            return $this->_usuarioRepository->Actualizar($_usuarioModel);
        }else{
            return $this->_usuarioRepository->Crear($_usuarioModel);
        }
    }
}
