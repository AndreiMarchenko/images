<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\UploadedFile;
use yii\web\Response;
use frontend\modules\user\models\forms\PictureForm;



class ProfileController extends Controller
{
    public function actionView($username)
    {
        $currentUser = Yii::$app->user->identity;
        $user = User::findByUsername($username);
        $modelPicture = new PictureForm();
        // echo '<pre>';
        // print_r($user);
        // echo '</pre>';die;

        $subscribers = $user->getSubscriptions();
        $followers = $user->getFollowers();
       
        return $this->render('profile', [
            'currentUser' => $currentUser,
            'user' => $user,
            'subscribers' => $subscribers,
            'followers' => $followers,
            'modelPicture' => $modelPicture,
        ]);
    }


    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PictureForm();
        $model->picture = UploadedFile::GetInstance($model, 'picture');
        if ($model->validate()) {
            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->savePicture($model->picture);
            if($user->save(false, ['picture'])) {
               return [
                'success' => true,
                'pictureUri' => Yii::$app->storage->getPicture($user->picture),
               ];
            }
        }
        return [
            'success' => false,
            'errors' => $model->getErrors(),
        ];
    }


    public function actionSubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $user = Yii::$app->user->identity;
        $subscribeTo = User::findById($id);
        $redis = Yii::$app->redis;
        $redis->sadd("user:{$user->id}:subscriptions", $subscribeTo->id);
        $redis->sadd("user:{$subscribeTo->id}:followers", $user->id);
        return $this->redirect(['/user/profile/view', 'username' => $subscribeTo->username]);
    }

    // public function actionSubscribe()
    // {
    //     if(Yii::$app->user->isGuest) {
    //         return $this->redirect('/user/default/login');
    //     }
    //     $id = Yii::$app->request->post('id');
    //     $user = Yii::$app->user->identity;
        

    //     $subscribeTo = User::findById($id);
    //     $redis = Yii::$app->redis;
    //     $redis->sadd("user:{$user->id}:subscriptions", $subscribeTo->id);
    //     $redis->sadd("user:{$subscribeTo->id}:followers", $user->id);

    //     Yii::$app->response->format = Response::FORMAT_JSON;

    //     if($user->isSubscribed($id)) {
    //         return [
    //             'subscribed' => true,
    //             'follower' => $user,
    //             'followercount' => User::findById($id)->getFollowerCount(),
    //         ];
    //     }
    //     return [
    //         'subscribed' => false,
    //         'follower' => $user,
    //         'followercount' => User::findById($id)->getFollowerCount(),
    //     ];
    // }
    // public function actionUnsubscribe()
    // {
    //     if (Yii::$app->user->isGuest) {
    //         return $this->redirect('/user/default/login');
    //     }
    //     $id = Yii::$app->request->post('id');
    //     $user = Yii::$app->user->identity;
       
    //     $redis = Yii::$app->redis;
    //     $redis->srem("user:{$user->id}:subscriptions", $id);
    //     $redis->srem("user:{$id}:followers", $user->id);

    //     Yii::$app->response->format = Response::FORMAT_JSON;
    //     if($user->isSubscribed($id)) {
    //         return [
    //             'subscribed' => true,
    //             'follower' => $user,
    //             'followercount' => User::findById($id)->getFollowerCount(),
    //         ];
    //     };
    //     return [
    //         'subscribed' => false,
    //         'follower' => $user,
    //         'followercount' => User::findById($id)->getFollowerCount(),
    //     ];
    // }
    public function actionUnsubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }
        $user = Yii::$app->user->identity;
        $redis = Yii::$app->redis;
        $redis->srem("user:{$user->id}:subscriptions", $id);
        $redis->srem("user:{$id}:followers", $user->id);
        return $this->redirect(['/user/profile/view', 'username' => User::findById($id)->username]);
    }

    // public function actionCheckSubscription()
    // {
    //     if(Yii::$app->user->isGuest) {
    //         return $this->redirect('/user/default/login');
    //     }
        
    //     $id = Yii::$app->request->get('id');
    //     Yii::$app->response->format = Response::FORMAT_JSON;

    //     if($this->isSubscribed($id)) {
    //         return [
    //             'subscribed' => true,
    //         ];
    //     }
    //     return [
    //         'subscribed' => false,
    //     ];
    // }
}
