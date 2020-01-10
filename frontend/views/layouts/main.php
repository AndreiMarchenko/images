<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use common\widgets\Alert;

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body class="home page">

        <div class="wrapper">
            <header>                
                <div class="header-top">
                    <div class="container">
                        <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4 brand-logo">
                            <h1>
                                <a href="<?php echo Url::to(['/site/index']); ?>">
                                    <img src="/img/logo.png" alt="">
                                </a>
                            </h1>
                        </div>
                        <div class="col-md-4 col-sm-4 navicons-topbar">
                            
                        </div>
                    </div>
                </div>


                <div class="header-main-nav">
                    <div class="container">
                        <div class="main-nav-wrapper">
                            <nav class="main-menu">      
                                
                                <?php 
                                $menuItems = [
                                        ['label' =>'Newsfeed', 'url' => ['/site/index']],
                                ];
                                if (Yii::$app->user->isGuest) {
                                    $menuItems[] = ['label' => 'Signup', 'url' => ['/user/default/signup']];
                                    $menuItems[] = ['label' => 'Login', 'url' => ['/user/default/login']];
                                } else {
                                    $menuItems[] = ['label' => 'My profile', 'url' => ['/user/profile/view', 'username' => Yii::$app->user->identity->username]];
                                    $menuItems[] = ['label' => 'Create post', 'url' => ['/post/default/add']];
                                    $menuItems[] = ['label' => 'Logout', 'url' => ['/user/default/logout']];
                                }
                                echo Nav::widget([
                                    'options' => ['class' => 'menu navbar-nav navbar-right'],
                                    'items' => $menuItems,
                                ]);
                                ?>
                            </nav>				
                        </div>
                    </div>
                </div>

            </header>	

            <div class="container full">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>

            <div class="push"></div>
        </div>

        <footer>                
            <div class="footer">
                <div class="back-to-top-page">
                    <a class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
                </div>
                <p class="text"><a href="<?php echo Url::to(['/site/about']); ?>">Images | 2017</a></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
