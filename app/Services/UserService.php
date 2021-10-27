<?php

namespace App\Services;

use App\Utilities\Rule;
use App\Models\UserModel;
use App\Utilities\Common;
use App\Exceptions\ApiException;

interface UserInterface
{
    public static function check_email_exist($email);
    public static function get_by_id($id);
    public static function get_by_email($email);
    public static function add($email, $full_name);
}

class UserService implements UserInterface
{
    /**
     * This function will check whether a email exists or not
     * @param string $email
     * @return \App\Models\UserModel
     */
    public static function check_email_exist($email)
    {
        Common::validate(compact("email"), [
            "email" => Rule::get("email", true),
        ]);

        $user = UserModel::where("email", $email)->first();
        return $user;
    }
    
    /**
     * @param integer $id
     * @return \App\Models\UserModel
     */
    public static function get_by_id($id)
    {
        return UserModel::where('id', $id)->first();
    }

    /**
     * @param integer $email
     * @return \App\Models\UserModel
     */
    public static function get_by_email($email)
    {
        return UserModel::where('email', $email)->first();
    }

    /**
     * add a user
     * @param string $email
     * @param array $full_name
     * @return \App\Models\UserModel
     */
    public static function add($email, $full_name)
    {
        Common::validate(compact("email", "full_name"), [
            "email" => Rule::get('email', true),
            "full_name" => Rule::get('name', true),
        ]);

        $user = UserService::check_email_exist($email);
        if ($user) throw new ApiException("Sorry, this email already exists.");

        $user = new UserModel();
        $user->email = $email;
        $user->full_name = $full_name;
        $user->save();

        return UserService::get_by_id($user->id);
    }
}
