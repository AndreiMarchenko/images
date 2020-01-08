<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>


<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'picture')->fileInput(); ?>

<?= $form->field($model, 'description'); ?>

<?= Html::submitButton('submit', ['class' => 'btn btn-primary']); ?>


<?php ActiveForm::end() ?>