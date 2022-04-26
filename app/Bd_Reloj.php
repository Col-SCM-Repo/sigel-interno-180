<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bd_Reloj extends Model
{
    protected $connection = 'bio_start';
    protected $table = 'TB_EVENT_LOG';
    protected $primaryKey = 'nEventLogIdn';

}
