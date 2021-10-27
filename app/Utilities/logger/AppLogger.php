<?php

namespace App\Utilities\logger;

use Illuminate\Support\Facades\Log;
use App\Utilities\logger\LoggerInterface;

class AppLogger implements LoggerInterface {
    public static function info($message)
    {
        Log::channel("single")->info($message);
    }

    public static function warning($message)
    {
        Log::channel("single")->warning($message);
    }

    public static function error($message)
    {
        Log::channel("single")->error($message);
    }
}