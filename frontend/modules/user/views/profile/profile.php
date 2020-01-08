<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use dosamigos\fileupload\FileUpload;

?>



<img src="<?= $user->getPicture() ?>" id="profile-picture">

<?php if(Yii::$app->user->identity && $user->equals(Yii::$app->user->identity)) : ?>
    <div style="display:none" class="alert alert-success display-none" id="profile-image-success">Profile image updated</div>
    <div style="display:none" class="alert alert-danger display-none" id="profile-image-fail"></div>


    <?= FileUpload::widget([
        'model' => $modelPicture,
        'attribute' => 'picture',
        'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
        'options' => ['accept' => 'image/*'],
        'clientOptions' => [
            'maxFileSize' => 2000000
        ],
        // Also, you can specify jQuery-File-Upload events
        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
            if (data.result.success) {
                  $("#profile-image-success").show();
                  $("#profile-image-fail").hide();
                  $("#profile-picture").attr("src", data.result.pictureUri);
              } else {
                  $("#profile-image-fail").html(data.result.errors.picture).show();
                  $("#profile-image-success").hide();
              }
        }',
        ],
    ]); ?>

<?php else : ?>


    <h3><?= Html::encode($user->nickname) ?></h3>

    <p>
        <?=
            HtmlPurifier::process($user->about);
        ?>
    </p>


    <a href="<?= Url::to(['/user/profile/subscribe', 'id' => $user->id]) ?>" id="<?= $user->id ?>" class="btn btn-primary">Subscribe</a>

    <a href="<?= Url::to(['/user/profile/unsubscribe', 'id' => $user->id]) ?>" id="<?= $user->id ?>" class="btn btn-primary">Unsubscribe</a>

<?php endif; ?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
    Subscribers: <?= $user->getSubscriptionCount() ?>
</button>


<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php if (Yii::$app->user->identity && !$user->equals(Yii::$app->user->identity)
                           && $mutualSubscriptions = $user->getMutualSubscriptions($user->id)) : ?>
             
                    Mutual subscribers: <br>
                    <?php foreach ($mutualSubscriptions as $subscriber) : ?>
                        <a href="<?= Url::to(['/user/profile/view', 'nickname' => $subscriber['nickname']]) ?>">
                            <?php
                            if ($subscriber['nickname']) {
                                echo $subscriber['nickname'];
                            } else {
                                echo $subscriber['id'];
                            }
                            ?>
                        </a>
                        <br>
                    <?php endforeach; ?>
                    <br>
                <?php endif; ?>
                <br>


                Subscribers:<br>
                <?php foreach ($subscribers as $subscriber) : ?>
                    <a href="<?= Url::to(['/user/profile/view', 'nickname' => $subscriber['nickname']]) ?>">
                        <?php
                        if ($subscriber['nickname']) {
                            echo $subscriber['nickname'];
                        } else {
                            echo $subscriber['id'];
                        }
                        ?>
                    </a>
                    <br>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong2">
    Followers: <?= $user->getFollowerCount() ?>
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Followers:<br>
                <?php foreach ($followers as $follower) : ?>
                    <a href="<?= Url::to(['/user/profile/view', 'nickname' => $follower['nickname']]) ?>">
                        <?php
                        if ($follower['nickname']) {
                            echo $follower['nickname'];
                        } else {
                            echo $follower['id'];
                        }
                        ?>
                    </a>
                    <br>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
</script>