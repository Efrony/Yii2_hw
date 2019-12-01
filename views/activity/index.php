<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var array $activities
 */
?>

<div class="row">
    <h1>Список событий</h1>
    <div class="form-group pull-right">
        <?= Html::a('Создать', ['activity/create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>

<?php foreach ($activities as $item): ?>
    <?= var_dump($item)?>
<?php endforeach;?>
