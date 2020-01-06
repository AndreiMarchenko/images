<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>






<h3><?= Html::encode($user->nickname) ?></h3>

<p>
    <?=
        HtmlPurifier::process($user->about);
    ?>
</p>

<a href="<?= Url::to(['/user/profile/subscribe', 'id' => $user->id]) ?>" id="<?= $user->id ?>" class="btn btn-primary">Subscribe</a>

<a href="<?= Url::to(['/user/profile/unsubscribe', 'id' => $user->id]) ?>" id="<?= $user->id ?>" class="btn btn-primary">Unsubscribe</a>

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

                <?php if ($mutualSubscriptions = $user->getMutualSubscriptions($user->id)) : ?>
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