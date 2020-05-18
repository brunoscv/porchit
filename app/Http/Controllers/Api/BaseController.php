<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message) 
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errormessage=[], $code = 400) 
    {
        $response = [
            'success' => false,
            'data' => '',
            'message' => $error
        ];

        if(!empty($errormessage)) {
            $response['data'] = $errormessage;
        }

        return response()->json($response, $code);
    }
}
