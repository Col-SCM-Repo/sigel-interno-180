<?php
namespace App\Structure\Services;

use App\Mappers\LocalMapper;
use App\Structure\Repository\LocalRepository;

class LocalService
{
    protected $_localMapper;
    protected $_localRepository;
    public function __construct()
    {
       $this->_localMapper = new LocalMapper();
       $this->_localRepository = new LocalRepository();
    }
    public function BuscarPorId($nivel_id)
    {
        return $this->_localMapper->ModelToViewModel($this->_localRepository->BuscarPorId($nivel_id));
    }

}
