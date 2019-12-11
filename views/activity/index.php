<?php

use yii\helpers\Html;
use app\models\Activity;
use yii\grid\SerialColumn;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/**
 * @var $this \yii\web\View
 * @var $provider \yii\data\ActiveDataProvider
 *
 */

$columns = [
    [
        'class' => SerialColumn::class,
        'header' => 'Псевдо-Порядковый номер'
    ],
    'id',
    'title',
    'day_start:date',
    'user_id',
    [
        'label' => 'Имя создателя',
        'attribute' => 'user.username',
    ],
    'repeat:boolean',
    'blocked:boolean',

];

if (Yii::$app->user->can('admin')) {
    $columns[] = [
        'class' => ActionColumn::class,
        'header' => 'Операции',
        'template' => '{view} {update} {delete} {edit}',
        'buttons' => [
            'edit' => function($url, $model, $key) {
                return Html::a('Edit', $url);
            }

        ],
    ];
}

?>

<div class="row">
    <h1>Список событий</h1>
    <div class="form-group pull-right">
        <?= Html::a('Создать', ['activity/create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>

<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]) ?>


