<?php

use yii\web\JqueryAsset;

?>




<h3> <?= $user->username ?> </h3>

<img src="<?= $picture ?>" alt="">

<p> <?= $post->description ?> </p>

Likes: <span class="likes-count"><?= $post->countLikes() ?></span><br>

<div>
    <a href="" id ="like" class="btn btn-primary button-like <?= ($currentUser && $post->isLikedBy($currentUser)) ?
     'display-none' : '' ?>" data-id="<?= $post->id ?>">Like</a>

    <a href="" id ="unlike" class="btn btn-primary button-unlike <?= ($currentUser && $post->isLikedBy($currentUser)) ?
     '' : 'display-none' ?>" data-id="<?= $post->id ?>">Unlike</a>
</div>



<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]); ?>