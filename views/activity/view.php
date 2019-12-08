<?php

use yii\helpers\Html;
use app\models\Activity;
use yii\widgets\DetailView;

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Activity
 *
 * <h2>Заголовок: <?= Html::encode($model->title)?></h2>
 * <p>Описание: <?= Html::encode($model->description)?></p>
 *
 * <ul>
 * <li>Дата начала: <?= Yii::$app->formatter->asDate($model->day_start, 'd.m.Y'); ?></li>
 * <li>Дата окончания: <?= Yii::$app->formatter->asDate($model->day_end, 'd.m.Y'); ?></li>
 * <li>Пользователь: <?= $model->user_id; ?></li>
 * <li>Повтор: <?= $model->repeat; ?></li>
 * <li>Блокировать другие события: <?= $model->blocked; ?></li>
 * </ul>
 */
?>


<div class="row">
    <h1>Просмотр события</h1>
    <div class="form-group pull-left">
        <?= Html::a('Редактировать', ['/activity/edit', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </div>
    <div class="form-group pull-right">
        <?= Html::a('Назад к списку событий', ['activity/index'], ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Порядковый номер',
            'value' => function (Activity $model) {
                return "# {$model->id}";
            }
        ],
        'title',
        'day_start:date',
        [
            'attribute' => 'day_end',
            'format' => ['date', 'php:Y-m-d'],
//            'value' => function (Activity $model) {
//                return Yii::$app->formatter->asDate($model->day_end, 'php:Y');
//            }

        ],
        'user_id',
        [
            'label' => 'Имя создателя',
            'attribute' => 'user.username',
        ],
        'description',
        'repeat:boolean',
        'blocked:boolean',
    ]
]); ?>






