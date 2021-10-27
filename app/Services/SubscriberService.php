<?php

namespace App\Services;

use App\Utilities\Rule;
use App\Models\SubscriberModel;
use App\Utilities\Common;

interface SubscriberInterface
{
    public static function check_subscriber_exist($user_id, $website_id);
    public static function get_by_id($id);
    public static function add($email, $full_name, $url);
}

class SubscriberService implements SubscriberInterface
{
    /**
     * This function will check whether a subscriptionexists or not
     * @param string $user_id
     * @param string $website_id
     * @return \App\Models\SubscriberModel
     */
    public static function check_subscriber_exist($user_id, $website_id)
    {
        Common::validate(compact("user_id", "website_id"), [
            "user_id" => Rule::get("id", true),
            "website_id" => Rule::get("id", true),
        ]);

        $subscriber = SubscriberModel::where("user_id", $user_id)->where("website_id", $website_id)->first();
        return $subscriber;
    }
    
    /**
     * @param integer $id
     * @return \App\Models\SubscriberModel
     */
    public static function get_by_id($id)
    {
        return SubscriberModel::where('id', $id)->first();
    }

    /**
     * add a user
     * @param string $email
     * @param string $full_name
     * @param string $url
     * @return \App\Models\SubscriberModel
     */
    public static function add($email, $full_name, $url)
    {
        Common::validate(compact("email", "full_name", "url"), [
            "email" => Rule::get('email', true),
            "full_name" => Rule::get('full_name', true),
            "url" => Rule::get('url', true),
        ]);

        $user = UserService::get_by_email($email);
        if (!$user) {
            $user = UserService::add($email, $full_name);
        }

        $website = WebsiteService::get_by_url($url);
        if (!$website) {
            $website = WebsiteService::add($url);
        }

        $subscriber = SubscriberService::check_subscriber_exist($user->id, $website->id);
        if(!$subscriber) {
            $subscriber = new SubscriberModel();
            $subscriber->user_id = $user->id;
            $subscriber->website_id = $website->id;
            $subscriber->save();
        }

        return SubscriberService::get_by_id($subscriber->id);
    }
}
