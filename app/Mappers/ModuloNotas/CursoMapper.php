<?php
namespace App\Mappers\ModuloNotas;

use App\Curso;
use App\ViewModel\ModuloNotas\CursoViewModel;

class CursoMapper
{
    public function ModelToViewModel(Curso $_curso)
    {
        $_cursoViewModel = new CursoViewModel();
        $_cursoViewModel->id = $_curso->id();
        $_cursoViewModel->curso = $_curso->curso();
        return $_cursoViewModel;
    }
    public function ListModelToViewModel($_cursos)
    {
        $_listCursos = [];
        foreach ($_cursos as $curso) {
            array_push($_listCursos, self::ModelToViewModel($curso));
        }
        return $_listCursos;
    }
}
