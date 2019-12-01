<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Activity
 */
?>

<h1>Список событий</h1>

<?php $form = ActiveForm::begin(['action' => ['/activity/index']]); ?>
<div class="form-group" style="margin-top: 40px; float: right">
    <?= Html::submitButton('Назад к списку событий', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin(['action' => ['/activity/create']]); ?>
<div class="form-group" style="margin-top: 60px;">
    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<h2><?= $model->title; ?></h2>
<p><?= $model->day_start; ?></p>
<p><?= $model->day_end; ?></p>
<p><?= $model->user_id; ?></p>
<p><?= $model->description; ?></p>
<p><?= $model->repeat; ?></p>
<p><?= $model->blocked; ?></p>


