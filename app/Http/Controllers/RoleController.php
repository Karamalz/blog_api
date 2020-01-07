<?php

namespace App\Http\Controllers;

use App\services\RoleService;
use Illuminate\Support\Facades\Auth;

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
        return view('admin')
            ->with('users',$users);
    }

    public function roleUpgrade($userId) 
    {
        $this->roleService->upgradeRole($userId);
        return redirect('/admin/index');
    }

    public function roleDowngrade($userId)
    {
        $this->roleService->downgradeRole($userId);
        return redirect('/admin/index');
    }
    
}
