<?php

namespace App\Repositories;

use App\User;
use DB;

class UserRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = DB::table('users')
            ->select('users.id', 'name', 'email', 'roles', 'description')
            ->join('roles', 'users.id', '=', 'roles.uid')
            ->orderBy('users.id')
            ->get();
        return $users;
    }

    public function register()
    {

    }

}
