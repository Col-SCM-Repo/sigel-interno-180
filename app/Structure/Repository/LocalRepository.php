<?php
namespace App\Structure\Repository;

use App\Local;

class LocalRepository extends Local
{
    public function BuscarPorId($local_id)
    {
        return $this::find($local_id);
    }
}
