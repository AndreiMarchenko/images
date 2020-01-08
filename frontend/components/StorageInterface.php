<?php

namespace frontend\components;

use yii\web\UploadedFile;

interface StorageInterface
{
    public function savePicture(UploadedFile $file);
  

    public function getPicture(string $filename);
   
}