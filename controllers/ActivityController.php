<?php


namespace app\controllers;


use app\models\Activity;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class ActivityController extends Controller
{
    public function actionIndex()
    {
        /**
         * Просмотр списка событий
         * @return string
         */
        return $this->render('index');
    }

    /**
     * Просмотр определенного события
     * @return string
     */
    public function actionView()
    {
        $model = new Activity([
            'title' => 'Сотворение ДЗ',
            'day_start' => '2019-11-26',
            'day_end' => '2019-11-27',
            'user_id' => 'id пользователя',
            'description' => 'Сижу ночью , пилю дз',
            'repeat' => true,
            'blocked' => true,

        ]);
        return $this->render('view', compact('model'));
    }

    /**
     * Создание нового события
     * @return string
     */
    public function actionCreate()
    {
        $model = new Activity();
        return $this->render('create', ['model' => $model]);
    }

    public function actionSubmit()
    {
        $model = new Activity();
        if ($model->load(Yii::$app->request->post())) {
            $model->attachments = UploadedFile::getInstance($model, 'attachments');

            if ($model->validate()) {
                return "Success: " . VarDumper::export($model->attributes);
            } else {
                return "Failed: " . VarDumper::export($model->errors);
            }
        }
        return 'submit activity';
    }
}