<?php

namespace App\services;

use App\repositories\RoleRepository;
use App\repositories\UserRepository;

class UserService
{
    protected $roleRepo;
    protected $userRepo;

    public function __construct(RoleRepository $roleRepo, UserRepository $userRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->userRepo = $userRepo;
    }

    public function register($request)
    {
        $reg = $this->userRepo->register($request);
        $this->roleRepo->setInitRole($reg->id);
        return $reg;
    }

}
