<?php

use yii\helpers\Url;

?>


<?php foreach($users as $user): ?>
    <h3><a href="<?= Url::to(['/user/profile/view', 'id' => $user->id]); ?>"><?= $user->username ?></a></h3>

<?php endforeach; ?>




