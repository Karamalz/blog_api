<?php

namespace App\services;

use App\repositories\RoleRepository;
use App\repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleService
{
    protected $roleRepo;
    protected $userRepo;

    public function __construct(RoleRepository $roleRepo, UserRepository $userRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $users = $this->userRepo->index();
        return $users;
    }

    public function upgradeRole($userId)
    {
        $this->roleRepo->upgrade($userId);
        return;
    }

    public function downgradeRole($userId)
    {
        $this->roleRepo->downgrade($userId);
        return;
    }

}