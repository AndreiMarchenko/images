<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use frontend\models\events\PostCreatedEvent;
use frontend\models\Feed;

class FeedService extends Component
{
    public function formFeed(PostCreatedEvent $event)
    {
        $followers = Yii::$app->user->identity->getFollowers();

        foreach($followers as $follower) {
            $model = new Feed();
            $model->user_id = $follower['id'];
            $model->author_id = $event->user->id;
            $model->author_name = $event->user->username;
            $model->author_nickname = $event->user->nickname;
            $model->author_picture = $event->user->picture;
            $model->post_id = $event->post->id;
            $model->post_filename = $event->post->filename;
            $model->post_description = $event->post->description;
            $model->post_created_at = $event->post->created_at;
            $model->save(false);
        }
    }
}