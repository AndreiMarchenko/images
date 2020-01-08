<?php

namespace frontend\components;

use Yii;
use frontend\components\StorageInterface;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\base\Component;

class Storage extends Component implements StorageInterface 
{
    private $fileName;

    public function savePicture(UploadedFile $file)
    {
       $path = $this->preparePath($file);
       if($path && $file->saveAs($path)) {
            return $this->fileName;
       }
    }

    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);

        $path = $this->getStoragePath() . $this->fileName;

        $path = FileHelper::normalizePath($path);
        if(FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    protected function getFileName(UploadedFile $file)
    {
        $hash = sha1_file($file->tempName);
        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);
        return $name . '.' . $file->extension;
    }

    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }

    public function getPicture(string $filename)
    {
        return Yii::$app->params['storageUri'] . $filename;
    }

   

    
}