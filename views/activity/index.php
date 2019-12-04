<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var \app\models\Activity[] $activities
 */
?>

<div class="row">
    <h1>Список событий</h1>
    <div class="form-group pull-right">
        <?= Html::a('Создать', ['activity/create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>

<?php foreach ($activities as $item): ?>
    <p><?= var_dump($item->title) ?>
        <div>
            <?= Html::a('Посмотреть', ["activity/view?id={$item->id}"], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Редактировать', ["activity/edit?id={$item->id}"], ['class' => 'btn btn-success']) ?>
        </div>
    </p>
    <br>
<?php endforeach; ?>
