<?php

namespace frontend\models\events;

use frontend\models\Post;
use frontend\models\User;
use yii\base\Event;

class PostCreatedEvent extends Event
{
    public $post;
    public $user;

    public function getUser() : User
    {
        return $this->user;
    }

    public function getPost() : Post
    {
        return $this->post;
    }
}