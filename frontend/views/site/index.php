<?php

use yii\helpers\Url;

?>


<?php foreach($users as $user): ?>
    <h3><a href="<?= Url::to(['user/profile/view', 'nickname' => $user->getNickname()]); ?>"><?= $user->username ?></a></h3>

<?php endforeach; ?>




