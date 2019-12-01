<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 */
?>


<div class="row">
    <h1>Просмотр события</h1>
    <div class="form-group pull-left">
        <?= Html::a('Редактировать', ['activity/create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="form-group pull-right">
        <?= Html::a('Назад к списку событий', ['activity/index'],['class' => 'btn btn-success']) ?>
    </div>
</div>


<h2>Заголовок: <?= Html::encode($model['title'])?></h2>
<p>Описание: <?= Html::encode($model['description'])?></p>

<ul>
    <li>Дата начала: <?= $model['day_start']; ?></li>
    <li>Дата окончания: <?= $model['day_end']; ?></li>
    <li>Пользователь: <?= $model['user_id']; ?></li>
    <li>Повтор: <?= $model['repeat']; ?></li>
    <li>Блокировать другие события: <?= $model['blocked']; ?></li>
</ul>



