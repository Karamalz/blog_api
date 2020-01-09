<?php

namespace App\Repositories;

use App\Role;

class RoleRepository
{

    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function setInitRole($userId)
    {
        return Role::create([
            'uid' => $userId,
            'roles' => 'normal',
            'description' => 'no special',
        ]);
    }

    public function upgrade($userId)
    {
        return Role::where('uid', $userId)->update(['roles' => 'admin']);
    }

    public function downgrade($userId)
    {
        return Role::where('uid', $userId)->update(['roles' => 'normal']);
    }

}
