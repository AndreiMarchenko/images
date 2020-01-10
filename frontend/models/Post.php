<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string|null $description
 * @property int $created_at
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findById($id)
    {
        return self::findOne(['id' => $id]);
    }

    public function userByPost()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->one();
    }
    public static function getPicture($id)
    {
        return Yii::$app->storage->getPicture(self::findById($id)->filename);
    }
    public function like(User $user) 
    {
        $redis = Yii::$app->redis;
        $redis->sadd("user:{$user->id}:likes", $this->id);
        $redis->sadd("post:{$this->id}:likes", $user->id);
    }
    public function unlike($user) 
    {
        $redis = Yii::$app->redis;
        $redis->srem("user:{$user->id}:likes", $this->id);
        $redis->srem("post:{$this->id}:likes", $user->id);
    }
    public function countLikes()
    {
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->id}:likes");
    }
    public function isLikedBy($user)
    {
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->id}:likes", $user->id);
    }
}
