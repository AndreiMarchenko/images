<?php

namespace frontend\modules\post\models;

use yii\base\Model;

use Yii;
use frontend\models\Post;
use frontend\models\User;
use frontend\models\events\PostCreatedEvent;
use Intervention\Image\ImageManager;


class PostForm extends Model
{
    const MAX_DESCRIPTION_LENGHT = 1000;
    const EVENT_AFTER_SAVE = 'event_after_save';

    public $picture;
    public $description;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
        $this->on(self::EVENT_AFTER_SAVE, [Yii::$app->feedservice, 'formFeed']);
    }

    public function resizePicture()
    {
        $width = Yii::$app->params['postPicture']['maxWidth'];
        $height = Yii::$app->params['postPicture']['maxHeight'];

        $manager = new ImageManager(['driver' => 'imagick']);
        $image = $manager->make($this->picture->tempName);
        $image->resize($width, $height, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save();
    }

    public function rules()
    {
        return [
            [['picture'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize(),
            ],
            [['description'],
                'string', 'max' => self::MAX_DESCRIPTION_LENGHT,
            ],
        ];
    }

    public static function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }

    public function save()
    {
        if($this->validate()) {
            $post = new Post();
            $post->user_id = $this->user->id;
            $post->filename = Yii::$app->storage->savePicture($this->picture);
            $post->created_at = time();
            $post->description = $this->description;
            if($post->save(false)) {
                $event = new PostCreatedEvent();
                $event->post = $post;
                $event->user = $this->user;
                $this->trigger(self::EVENT_AFTER_SAVE, $event);
                return true;
            }
        }
        return false;
    }
}