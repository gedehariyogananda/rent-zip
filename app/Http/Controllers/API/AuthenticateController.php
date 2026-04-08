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
            $userCheck = User::where('email', $request->email)->first();
            if (!$userCheck) {
                return $this->apiError('User not found', 404);
            }

            if (!$token = Auth::guard('api')->attempt($validates->validated())) {
                return $this->apiError('Unauthorized', 401);
            }

            return $this->apiSuccess([
                'id' => $userCheck->id,
                'nama' => $userCheck->nama,
                'email' => $userCheck->email,
                'photo_profile' => $userCheck->photo_profile,
                'division_id' => $userCheck->division->nama_divisi,
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
