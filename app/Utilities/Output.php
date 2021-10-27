<?php

namespace App\Utilities;

class Output{
    public static function success($message = "", $data = []){
        return Output::output(200, $message, $data);
    }

    public static function error($message = ""){
        return Output::output(400, $message);
    }

    public static function fatal(){
        return Output::output(500, "Sorry, Something is wrong.");
    }

    public static function not_found(){
        return Output::output(404, "Sorry, Not found.");
    }

    public static function output($status = 200, $message = "", $data = []){
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ]);
    }
}