<?php

/**
 *  $ php composer.phar require edofre/yii2-fullcalendar "V1.0.11"
 */

namespace app\controllers;
use app\models\Activity;
use Yii;
use yii\web\Controller;
class CalendarController extends Controller
{
    public function actionIndex()
    {
        $events = Activity::findAll(['user_id' => Yii::$app->user->id]);
        $events = array_map(function (Activity $event) {
            return $event->toEvent();
        }, $events);
        return $this->render('month', compact('events'));
    }
}