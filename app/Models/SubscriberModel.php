<?php

namespace App\Models;

use App\Models\Model;
use App\Models\UserModel;

class SubscriberModel extends Model
{
    protected $table = 'subscribers';

    // relation
    public function user()
    {
        return $this->belongsTo(UserModel::class, "user_id");
    }
}
