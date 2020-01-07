<?php

namespace App\Http\Controllers;

use App\services\RoleService;

class RoleController extends Controller
{
    protected $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $users = $this->roleService->index();
        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'NO users information',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Query success',
                'data' => $users,
            ], 200);
        }
    }

    public function roleUpgrade($userId)
    {
        
        if ($this->roleService->upgradeRole($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upgrade role',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Upgrade success',
                'data' => '',
            ], 200);
        }
    }

    public function roleDowngrade($userId)
    {
        if ($this->roleService->downgradeRole($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to downgrade role',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Downgrade success',
                'data' => '',
            ], 200);
        }
    }

}
