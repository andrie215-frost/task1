<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthTokenController extends Controller
{
    /**
     * Create a Sanctum access token.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],

            'device_name' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);


        $user = User::query()
            ->where('email', $validated['email'])
            ->first();


        if (
            !$user ||
            !Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 422);
        }


        $deviceName =
            $validated['device_name']
            ?? 'SkillMatch API';


        $token = $user
            ->createToken($deviceName)
            ->plainTextToken;


        return response()->json([
            'message' => 'Token created successfully.',

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],

            'token' => $token,
        ]);
    }


    /**
     * Return the authenticated API user.
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }


    /**
     * Revoke the token currently being used.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()
            ->currentAccessToken()
            ->delete();


        return response()->json([
            'message' => 'Token revoked successfully.',
        ]);
    }
}