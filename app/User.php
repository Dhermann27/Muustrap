<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(\App\Role::class);
    }

    public function camper() {
        return $this->hasOne(\App\Camper::class, 'email', 'email');
    }

    public function thiscamper() {
        return $this->hasOne(\App\Thisyear_Camper::class, 'email', 'email');
    }

}
