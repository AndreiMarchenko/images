<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use frontend\models\Post;
use frontend\modules\post\models\PostForm;
use yii\web\Response;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
   public function actionAdd()
   {
       $model = new PostForm(Yii::$app->user->identity);
       if($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');

           if($model->save()) {
            Yii::$app->session->setFlash('success', 'Posted!');
           }
       }
        
       return $this->render('add', [
                'model' => $model,
       ]);
   }
   public function actionLike()
   {
       if(Yii::$app->user->isGuest) {
           return $this->redirect('/user/default/login');
       }
       Yii::$app->response->format = Response::FORMAT_JSON;


       $id = Yii::$app->request->post('id');
       $post = Post::findById($id);


       $post->like(Yii::$app->user->identity);
       return [
        'likesCount' => $post->countLikes(),
       ];
   }

   public function actionUnlike()
   {
       if(Yii::$app->user->isGuest) {
           return $this->redirect('/user/default/login');
       }
       Yii::$app->response->format = Response::FORMAT_JSON;


       $id = Yii::$app->request->post('id');
       $post = Post::findById($id);


       $post->unlike(Yii::$app->user->identity);
       return [
            'likesCount' => $post->countLikes(),
       ];
   }

   public function actionView($id)
   {
       $post = Post::findById($id);
       $currentUser = Yii::$app->user->identity;
       $user = $post->userByPost();
       $picture = Post::getPicture($id);
    //    echo '<pre>';
    //    print_r($user);
    //    echo '</pre>';die;
        return $this->render('view', [
            'post' => $post,
            'user' => $user,
            'picture' => $picture,
            'currentUser' => $currentUser,
        ]);
   }
}
