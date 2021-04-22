<?php
namespace App\Structure\Services;

use App\Mappers\ReligionMapper;
use App\Structure\Repository\ReligionRepository;

class ReligionService
{
    protected $_religionMapper;
    protected $_religionRepository;
    public function __construct()
    {
       $this->_religionMapper = new ReligionMapper();
       $this->_religionRepository = new ReligionRepository();
    }
    public function ObtenerReligiones()
    {
        return $this->_religionMapper->ListModelToViewModel($this->_religionRepository->ObtenerTodos());
    }

}
