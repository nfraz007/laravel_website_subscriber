<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriberMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $url;
    public $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $url, $post)
    {
        $this->user = $user;
        $this->url = $url;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscriber')->with([
            "full_name" => $this->user->full_name,
            "url" => $this->url,
            "title" => $this->post->title,
            "description" => $this->post->description,
        ]);
    }
}
