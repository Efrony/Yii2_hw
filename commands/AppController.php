<?php


namespace app\commands;


use app\models\Activity;
use app\models\User;
use yii\console\Controller;

class AppController extends Controller
{
    /**
     * Создание начальных пользователей
     * php yii app/users
     */
    public function actionUsers()
    {
        $users = [
            'admin',
            'manager',
            'user',
        ];

        foreach ($users as $login) {
            $user = new  User([
                'username' => $login,
                'access_token' => "{$login}-token",
                'created_at' => time(),
                'updated_at' => time(),
            ]);

            $user->generateAuthKey();
            $user->password = '123'; // setPassword('123')
            $user->save();
        }
    }

    public function actionActivities()
    {
        $titles = [
            'Первое событие',
            'Второе событие',
            'Третье событие',
        ];

        $day = 1;
        $today = time();

        foreach ($titles as $title) {
            $activityDate = date('Y-m-d', strtotime("+ {$day} days", $today));
            $activity = new Activity([
                'title' => $title,
                'description' => chunk_split(\Yii::$app->security->generateRandomString(64), random_int(10, 20), ' '),'title' => $title,
                'user_id' => random_int(1,3),
                'day_start' => $activityDate,
                'day_end' => $activityDate,
                'blocked' => random_int(0,1),
                'repeat' => false,
            ]);
            $activity->save();
            $day++;
        }
    }
}