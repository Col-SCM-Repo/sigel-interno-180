<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'USUARIO';
    protected $primaryKey = 'USU_ID';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'USU_ID',
        'USU_NOMBRES',
        'USU_APELLIDOS',
        'username',
        'password',
        'USU_CONTRASENIA',
        'USU_USUARIO'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    public function Matriculas()
    {
      return $this->hasMany('App\Matricula', 'USU_ID', 'USU_ID');
    }
    public function Pagos()
    {
      return $this->hasMany('App\Pago', 'USU_ID', 'USU_ID');
    }

    public function nombres()
    {
        return $this->USU_NOMBRES;
    }
    public function apellidos()
    {
        return $this->USU_APELLIDOS;
    }
}
