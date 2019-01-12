<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_Role extends Model
{
    protected $table = "permission_role";
    protected $fillable = ['role_id', 'permission_id'];
    public $timestamps = false;

    public function permission(){
        return $this->hasOne(\App\Permission::class, 'id', 'permission_id');
    }

    public function role() {
        return $this->hasOne(\App\Role::class, 'id', 'role_id');
    }
}
