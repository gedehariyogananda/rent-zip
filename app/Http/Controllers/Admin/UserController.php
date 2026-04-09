<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;
    protected RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        $users = $this->userService->getAll();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roleService->getAll();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // TODO: implement
        return redirect()->route('admin.users.index');
    }

    public function show($id)
    {
        $user = $this->userService->find($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->userService->find($id);
        $roles = $this->roleService->getAll();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // TODO: implement
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        // TODO: implement
        return redirect()->route('admin.users.index');
    }
}
