<?php
namespace App\Structure\Repository;

use App\Religion;

class ReligionRepository extends Religion
{
    public function ObtenerTodos()
    {
        return $this::all();
    }
}
