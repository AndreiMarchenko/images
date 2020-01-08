<?php

namespace frontend\modules\post\models;

use yii\base\Model;

use Yii;
use frontend\models\Post;
use frontend\models\User;

class PostForm extends Model
{
    const MAX_DESCRIPTION_LENGHT = 1000;

    public $picture;
    public $description;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
            return $post->save(false);
        }
    }
}