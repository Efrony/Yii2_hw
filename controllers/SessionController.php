<?php


namespace app\controllers;


use yii\web\Controller;

class SessionController extends Controller
{
    public function afterAction($action, $result)
    {
        $url = \Yii::$app->request->url;
        \Yii::$app->session->set('last_page', $url);
        return parent::afterAction($action, $result);
    }
}