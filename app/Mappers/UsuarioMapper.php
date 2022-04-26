<?php
namespace App\Mappers;

use App\Pais;
use App\User;
use App\ViewModel\UsuarioViewModel;
use Illuminate\Support\Facades\Hash;

class UsuarioMapper
{
    public function ModelToViewModel(User $_usaurioM)
    {
        $_usuarioVM = new UsuarioViewModel();
        $_usuarioVM->id =$_usaurioM->USU_ID;
        $_usuarioVM->apellidos =$_usaurioM->USU_APELLIDOS;
        $_usuarioVM->nombres =$_usaurioM->USU_NOMBRES;
        $_usuarioVM->usuario =$_usaurioM->username;
        $_usuarioVM->cargo =$_usaurioM->USU_CARGO;
        $_usuarioVM->tipo =$_usaurioM->USU_TIPO;
        $_usuarioVM->estado =$_usaurioM->USU_ESTADO;
        return $_usuarioVM;
    }
    public function ListModelToViewModel($_usuarios)
    {
        $_listaUsuarios = [];
        foreach ($_usuarios as $usuario) {
            array_push($_listaUsuarios, self::ModelToViewModel($usuario));
        }
        return $_listaUsuarios;
    }
    public function ViewModel()
    {
        return new UsuarioViewModel();
    }

    public function ViewModelToModel($_usuarioVM)
    {
        $_usaurioM = new User();
        $_usaurioM->USU_ID =$_usuarioVM->id;
        $_usaurioM->USU_APELLIDOS =mb_strtoupper($_usuarioVM->apellidos);
        $_usaurioM->USU_NOMBRES =mb_strtoupper($_usuarioVM->nombres);
        $_usaurioM->username =$_usuarioVM->usuario;
        $_usaurioM->USU_CARGO =mb_strtoupper($_usuarioVM->cargo);
        $_usaurioM->USU_TIPO =$_usuarioVM->tipo;
        $_usaurioM->USU_ESTADO =$_usuarioVM->estado;
        $_usaurioM->password = $_usuarioVM->password?bcrypt($_usuarioVM->password):null;
        return $_usaurioM ;
    }
}
