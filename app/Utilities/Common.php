<?php

namespace App\Utilities;

use Validator;
use App\Exceptions\ApiException;

class Common
{

    /**
     * get current datetime
     * @return string
     */
    public static function now()
    {
        return date("Y-m-d H:i:s");
    }

    public static function validate($arr = [], $rules = []) {
        $validator = Validator::make($arr, $rules);

        if ($validator->fails()) {
            throw new ApiException($validator->errors()->first());
        }
    }
}
