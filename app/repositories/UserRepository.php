<?php

namespace App\Repositories;

use App\entities\User;
use Illuminate\Support\Facades\DB;

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

    public function register($request)
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }

}
