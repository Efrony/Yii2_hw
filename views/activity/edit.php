<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Activity
 * @var $form \yii\widgets\ActiveForm
 */
?>

<h1>Редактирвать событие</h1>
<div class ="activity-form">
    <?php $form = ActiveForm::begin(['action' => ["/activity/submit?id={$model->id}"]]);?>

    <?= $form->field($model, 'title')->textInput(['autocomplete' => 'off']) ?>
    <?= $form->field($model, 'day_start')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'day_end')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'user_id')->textInput(['autocomplete' => 'off']) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
    <?= $form->field($model, 'repeat')->checkbox() ?>
    <?= $form->field($model, 'blocked')->checkbox() ?>

    <div class="form-group" style="margin-top: 40px">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

