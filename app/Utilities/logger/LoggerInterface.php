<?php

namespace App\Utilities\logger;

interface LoggerInterface {
    public static function info($message);
    public static function warning($message);
    public static function error($message);
}