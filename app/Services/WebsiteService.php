<?php

namespace App\Services;

use App\Utilities\Rule;
use App\Models\WebsiteModel;
use App\Utilities\Common;
use App\Exceptions\ApiException;

interface WebsiteInterface
{
    public static function check_url_exist($url);
    public static function get_by_id($id);
    public static function get_by_url($url);
    public static function add($url);
}

class WebsiteService implements WebsiteInterface
{
    /**
     * This function will check whether a url exists or not
     * @param string $url
     * @return \App\Models\WebsiteModel
     */
    public static function check_url_exist($url)
    {
        Common::validate(compact("url"), [
            "url" => Rule::get("url", true),
        ]);

        $user = WebsiteModel::where("url", $url)->first();
        return $user;
    }
    
    /**
     * @param integer $id
     * @return \App\Models\WebsiteModel
     */
    public static function get_by_id($id)
    {
        return WebsiteModel::where('id', $id)->first();
    }

    /**
     * @param integer $url
     * @return \App\Models\WebsiteModel
     */
    public static function get_by_url($url)
    {
        return WebsiteModel::where('url', $url)->first();
    }

    /**
     * add a user
     * @param string $url
     * @return \App\Models\WebsiteModel
     */
    public static function add($url)
    {
        Common::validate(compact("url"), [
            "url" => Rule::get('url', true),
        ]);

        $user = WebsiteService::check_url_exist($url);
        if ($user) throw new ApiException("Sorry, this url already exists.");

        $user = new WebsiteModel();
        $user->url = $url;
        $user->save();

        return WebsiteService::get_by_id($user->id);
    }
}
