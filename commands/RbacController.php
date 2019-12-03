<?php


namespace app\commands;


use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $adminRole = $auth->createRole('admin');
        $adminRole->description = 'super admin';
        $auth->add($adminRole);

        $auth->assign($adminRole, 1);
    }
}