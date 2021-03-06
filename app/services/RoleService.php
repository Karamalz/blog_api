<?php

namespace App\services;

use App\repositories\RoleRepository;
use App\repositories\UserRepository;

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
        return $this->roleRepo->upgrade($userId);
    }

    public function downgradeRole($userId)
    {
        return $this->roleRepo->downgrade($userId);
    }

}
