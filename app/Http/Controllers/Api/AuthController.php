<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use ymon\JWTAuth\PayloadFactory;
use App\AppUsers;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = AppUsers::where('email','=', $request->get('email'))->first();
        $data = [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'address' =>$user->address,
            'zipcode' => $user->zipcode,
        ];
        $token = JWTAuth::fromUser($user, $data);
        //return $token;
        //$payload = JWTAuth::parseToken()->getPayload();
        // then either of
        //return $payload->get('zipcode');
        // return $this->respondWithToken($token);
        return response()->json(compact('token', 'data'));
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 1440
        ]);
    }
}
