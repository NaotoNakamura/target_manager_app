<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth;
use App\Models\User;
use JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api', ['except' => ['login']]);
    }

    public function register(Request $request){
        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();
        return $this->publishToken($request);
    }

    public function login(Request $request){
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function publishToken($request) {
        $token = auth('api')->attempt(['email' => $request->email, 'password' => $request->password]);
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
