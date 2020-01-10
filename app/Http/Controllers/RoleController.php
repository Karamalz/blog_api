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
        return response()->json([
            'success' => true,
            'message' => $users->isEmpty() ? 'NO users information' : 'Query success',
            'data' => $users->isEmpty() ? '' : $users,
        ], 200);
    }

    public function roleUpgrade($userId)
    {
        if (!preg_match('/^[0-9]+$/', $userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user ID',
                'data' => '',
            ], 422);
        }
        $response = $this->roleService->upgradeRole($userId);
        return response()->json([
            'success' => true,
            'message' => $response ? 'Upgrade success' : 'Failed to upgrade role',
            'data' => '',
        ], 200);
    }

    public function roleDowngrade($userId)
    {
        if (!preg_match('/^[0-9]+$/', $userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user ID',
                'data' => '',
            ], 422);
        }
        $response = $this->roleService->downgradeRole($userId);
        return response()->json([
            'success' => true,
            'message' => $response ? 'Downgrade success' : 'Failed to downgrade role',
            'data' => '',
        ], 200);
    }

}
