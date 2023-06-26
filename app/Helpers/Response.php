<?php

namespace App\Helpers;

class Response{

    public static function success($data,$message){
        return json_encode([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ]);
    }


}
