<?php


namespace app\controllers;


use app\models\Activity;
use yii\web\Controller;
use Yii;

class ActivityController extends SessionController
{
    public function actionIndex()
    {
        return 'OK';
    }

    public function actionView()
    {
        $activityItem = new Activity();
        $activityItem->title = 'New Activity Heading';

        return $this->render('view', [
            'model' => $activityItem
        ]);
    }

    public function actionCreate()
    {
        // создание
    }
}