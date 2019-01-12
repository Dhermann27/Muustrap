<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_User extends Model
{
    protected $table = "role_user";
    protected $fillable = ['role_id', 'user_id'];
    public $timestamps = false;

    public function role() {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
