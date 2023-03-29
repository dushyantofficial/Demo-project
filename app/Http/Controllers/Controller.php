<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function api_success_response($message = 'Success !', $data = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
            'result' => (count($data) > 0) ? $data : new \stdClass(),
        ];
        return response()->json($response, 200);
    }

    public function api_error_response($error_msg = 'Error !', $data = [])
    {
        $response = [
            'success' => false,
            'message' => $error_msg,
            'result' => (count($data) > 0) ? $data : new \stdClass(),
        ];
        return response()->json($response, 200);
    }

}


