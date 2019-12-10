<?php


namespace app\commands;


use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * php yii rbac/init
     */

    public function actionInit()
    {
        // аналогично выполнению в терминале 'php yii migrate --migrationPath=@yii/rbac/migrations
        \Yii::$app->runAction('migrate', ['migratePath' => '@yii/rbac/migrations']);

        //компонент управления RBAC
        $auth = \Yii::$app->authManager;

        /**
         * Создание ролей пользователей
         */
        // обычный пользователь
        $roleUsers = $auth->createRole('user');
        $roleUsers->description = 'Обычный пользователь';
        $auth->add($roleUsers);

        // менеджер
        $roleManager = $auth->createRole('manager');
        $roleManager->description = 'Менеджер';
        $auth->add($roleManager);
        $auth->addChild($roleManager, $roleUsers); // Менеджер наследует права Пользователя

        // Администратор
        $roleAdmin = $auth->createRole('admin');
        $roleAdmin->description = 'Администратор';
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $roleManager); // Администратор наследует права Менеджера

        /**
         * Установка ролей для пользователей
         */

        $auth->assign($roleAdmin, 1);
        $auth->assign($roleManager, 2);
        $auth->assign($roleUsers, 3);
    }
}