<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Register a new user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new user
        $user = new \App\Models\User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        // Issue a token
        $token = $user->createToken('MyApp')->accessToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * Log in the user and issue a token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to log in the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Successful login, issue a token
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json(['token' => $token], 200);
        }

        // Failed login attempt
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Log the user out (revoke the token).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
