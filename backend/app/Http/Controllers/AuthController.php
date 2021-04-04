<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordChangeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the login, logout, change user password functionality.
    |
    */

    /**
     * Change the authenticated user's password.
     *
     * @param  PasswordChangeRequest  $request
     * @return JsonResponse
     */
    public function changePassword(PasswordChangeRequest $request): JsonResponse
    {
        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = $request->validated()['password'];
            $user->save();

            return response()->json(null, 204);
        } else
            return response()->json(['errors' => ['auth' => [__('auth.password_failed')]]], 422);
    }

    /**
     * Authenticate the user.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        if (Auth::attempt($validatedData))
            return response()->json(null, 204);
        else
            return response()->json(['errors' => ['auth' => [__('auth.failed')]]], 401);
    }

    /**
     * Logout the authenticated user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return response()->json(Auth::logout(), 204);
    }

    /**
     * Display the authenticated user.
     *
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        return response()->json(Auth::user());
    }
}
