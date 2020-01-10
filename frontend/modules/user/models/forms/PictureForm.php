<?php

namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;
use Intervention\Image\ImageManager;

class PictureForm extends Model
{
    public $picture;


    public function rules()
    {
        return [
            [
                ['picture'],
                'file',
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
            ]
        ];
    }

    public function __construct()
    {
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }

    public function resizePicture()
    {
        $width = Yii::$app->params['profilePicture']['maxWidth'];
        $height = Yii::$app->params['profilePicture']['maxHeight'];

        $manager = new ImageManager(['driver' => 'imagick']);
        $image = $manager->make($this->picture->tempName);
        $image->resize($width, $height, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save();
    }

    public function save()
    {
        
    }
}
