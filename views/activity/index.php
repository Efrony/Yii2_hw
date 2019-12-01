<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Activity
 * @var $form \yii\widgets\ActiveForm
 */
?>

    <h1>Список событий</h1>

<?php $form = ActiveForm::begin(['action' => ['/activity/create']]); ?>

    <div class="form-group" style="margin-top: 40px; margin-left: 80%">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin(['action' => ['/activity/view']]); ?>
<div class="form-group" style="margin-top: 60px;">
    <?= Html::submitButton('Событие_1', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin(['action' => ['/activity/view']]); ?>
<div class="form-group" style="margin-top: 60px;">
    <?= Html::submitButton('Событие_2', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
