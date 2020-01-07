<?php

namespace App\Repositories;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class RoleRepository{

    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function checkRoleInit($userId)
    {
        Role::firstOrCreate(
            ['uid' => $userId],
            ['roles' => 'normal',
            'description' => 'no special']
        );
        return;
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