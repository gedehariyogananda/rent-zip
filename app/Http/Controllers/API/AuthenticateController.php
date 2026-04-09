<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        $validates = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validates->fails()) {
            return response()->json($validates->errors(), 400);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->apiError(404, 'User not found');
            }

            if (!$user->is_active) {
                return $this->apiError(403, 'Account is not active');
            }

            if (!$token = Auth::guard('api')->attempt($validates->validated())) {
                return $this->apiError(401, 'Unauthorized');
            }

            return $this->apiSuccess([
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role->name,
                'token' => $token,
            ], 200, 'Authentication successfully');
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->apiSuccess(null, 200, 'Logout successfully');
    }
}
