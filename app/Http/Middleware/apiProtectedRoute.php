<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Closure;

class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // caching the next action
        $response = $next($request);

        try {
            if (! $user = JWTAuth::parseToken()->authenticate() )
            {
                return response()->json([
                   'code'   => 101, // means auth error in the api,
                   'response' => null // nothing to show 
                ]);
            }
        } catch (TokenExpiredException $e)
        {
            // If the token is expired, then it will be refreshed and added to the headers
            try
            {
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshed)->toUser();
                header('Authorization: Bearer ' . $refreshed);
            }
            catch (JWTException $e)
            {
                 return response()->json([
                   'code'   => 103, // means not refreshable 
                   'response' => null // nothing to show 
                 ]);
            }
        }
        catch (JWTException $e)
        {
            return response()->json([
                   'code'   => 101, // means auth error in the api,
                   'response' => null // nothing to show 
            ]);
        }

        //Auth::login($user, false);

        return $response;
    }

    // public function handle($request, Closure $next) {
    //     try {
    //         $user = JWTAuth::parseToken()->authenticate();
    //         if (! $user = JWTAuth::parseToken()->authenticate() )
    //         {
    //             return response()->json([
    //                'code'   => 101, // means auth error in the api,
    //                'response' => null // nothing to show 
    //             ]);
    //         }
    //     } 
    //     catch (\Exception $e) {
    //         if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
    //             return response()->json(['status' => 'Token is invalid']);
    //         } else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
    //             return response()->json(['status' => 'Token is expired']);
    //         } else {
    //             return response()->json(['status' => 'Authorization Token not found']);
    //         }
    //     }
    //     return $next($request);
    // }
}
