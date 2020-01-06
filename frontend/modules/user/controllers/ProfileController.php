<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;

class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        $user = User::findByNickname($nickname);
        $subscribers = $user->getSubscriptions();
        $followers = $user->getFollowers();
        return $this->render('profile', [
            'user' => $user,
            'subscribers' => $subscribers,
            'followers' => $followers,
        ]);
    }

    public function actionSubscribe($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $user = Yii::$app->user->identity;
        $subscribeTo = User::findById($id);
        $redis = Yii::$app->redis;
        $redis->sadd("user:{$user->id}:subscriptions", $subscribeTo->id);
        $redis->sadd("user:{$subscribeTo->id}:followers", $user->id);
        return $this->redirect(['/user/profile/view', 'nickname' => $subscribeTo->getNickname()]);
    }

    public function actionUnsubscribe($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $user = Yii::$app->user->identity;
        $redis = Yii::$app->redis;
        $redis->srem("user:{$user->id}:subscriptions", $id);
        $redis->srem("user:{$id}:followers", $user->id);
        return $this->redirect(['/user/profile/view', 'nickname' => User::findById($id)->getNickname()]);
    }


    
}