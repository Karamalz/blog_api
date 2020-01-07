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

    public function checkRoleInit($userId)
    {
        return Role::firstOrCreate(
            ['uid' => $userId],
            ['roles' => 'normal',
                'description' => 'no special']
        );
    }

    public function upgrade($userId)
    {
        Role::where('uid', $userId)->update(['roles' => 'admin']);
    }

    public function downgrade($userId)
    {
        Role::where('uid', $userId)->update(['roles' => 'normal']);
    }

}
