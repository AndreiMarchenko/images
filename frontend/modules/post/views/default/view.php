<?php
/* @var $this yii\web\View */
/* @var $post frontend\models\Post */

use yii\helpers\Html;
use yii\web\JqueryAsset;
use frontend\models\Post;

?>
<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <?php if ($post->userByPost()): ?>
                <?php echo $post->userByPost()->username; ?>
            <?php endif; ?>
        </div>
        
        <div class="col-md-12">
            <img src="<?php echo Post::getPicture($post->id); ?>" />
        </div>

        <div class="col-md-12">
            <?php echo Html::encode($post->description); ?>
        </div>
        
    </div>

    <hr>
    
    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>
        
        <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->id; ?>">
            Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
        </a>
        <a href="#" class="btn btn-primary button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->id; ?>">
            Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
        </a>
                <br>
                <br>
                <br>
    </div>

</div>


<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);
