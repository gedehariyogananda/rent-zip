<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roleName = $request->query("role", "member");

        $role = Role::where("name", $roleName)->first();
        // Fallback to standard IDs if role is not found by name
        $roleId = $role ? $role->id : ($roleName === "admin" ? 1 : 2);

        $users = User::with("role")->where("role_id", $roleId)->latest()->get();

        return view("admin.users.index", compact("users", "roleName"));
    }

    public function create()
    {
        $roles = Role::all();
        return view("admin.users.create", compact("roles"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "username" => "required|string|max:255|unique:users",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:8",
            "phone" => "nullable|string|max:20",
            "address" => "nullable|string",
            "role_id" => "required|exists:roles,id",
        ]);

        $user = User::create([
            "username" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone" => $request->phone,
            "address" => $request->address,
            "role_id" => $request->role_id,
            "is_active" => true,
        ]);

        if ($user->role_id != 1) {
            $user->profile()->create([]);
        }

        $roleParam = $request->role_id == 1 ? "admin" : "member";
        return redirect()
            ->route("admin.users.index", ["role" => $roleParam])
            ->with("success", "User berhasil ditambahkan");
    }

    public function show(User $user)
    {
        $user->load([
            "role",
            "profile",
            "orders" => function ($query) {
                $query->latest();
            },
        ]);
        return view("admin.users.show", compact("user"));
    }

    public function edit(User $user)
    {
        $user->load("profile");
        $roles = Role::all();
        return view("admin.users.edit", compact("user", "roles"));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            "username" => [
                "required",
                "string",
                "max:255",
                Rule::unique("users")->ignore($user->id),
            ],
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                Rule::unique("users")->ignore($user->id),
            ],
            "password" => "nullable|string|min:8",
            "phone" => "nullable|string|max:20",
            "address" => "nullable|string",
            "role_id" => "required|exists:roles,id",
        ]);

        $data = [
            "username" => $request->username,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "role_id" => $request->role_id,
        ];

        if ($request->filled("password")) {
            $data["password"] = Hash::make($request->password);
        }

        $user->update($data);

        $roleParam = $user->role_id == 1 ? "admin" : "member";
        return redirect()
            ->route("admin.users.index", ["role" => $roleParam])
            ->with("success", "User berhasil diperbarui");
    }

    public function destroy(User $user)
    {
        $roleParam = $user->role_id == 1 ? "admin" : "member";
        $user->delete();

        return redirect()
            ->route("admin.users.index", ["role" => $roleParam])
            ->with("success", "User berhasil dihapus");
    }
}
