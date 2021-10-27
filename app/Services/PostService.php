<?php

namespace App\Services;

use App\Utilities\Rule;
use App\Models\PostModel;
use App\Utilities\Common;
use App\Mail\SubscriberMail;
use App\Models\SubscriberModel;
use Illuminate\Support\Facades\Mail;

interface PostInterface
{
    public static function get_by_id($id);
    public static function add($url, $title, $description);
}

class PostService implements PostInterface
{
    /**
     * @param integer $id
     * @return \App\Models\PostModel
     */
    public static function get_by_id($id)
    {
        return PostModel::where('id', $id)->first();
    }

    /**
     * add a user
     * @param string $url
     * @param string $title
     * @param string $description
     * @return \App\Models\PostModel
     */
    public static function add($url, $title, $description)
    {
        Common::validate(compact("url", "title", "description"), [
            "url" => Rule::get('url', true),
            "title" => Rule::get('text_200', true),
            "description" => Rule::get('text', true),
        ]);
        
        $website = WebsiteService::get_by_url($url);
        if (!$website) {
            $website = WebsiteService::add($url);
        }

        $post = new PostModel();
        $post->website_id = $website->id;
        $post->title = $title;
        $post->description = $description;
        $post->save();

        // send email
        $subscribers = SubscriberModel::with("user")->where("website_id", $website->id)->get();

        foreach($subscribers as $subscriber) {
            if ($subscriber->user) {
                Mail::to($subscriber->user->email)->queue(new SubscriberMail($subscriber->user, $url, $post));
            }
        }

        return PostService::get_by_id($post->id);
    }
}
