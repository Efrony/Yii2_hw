<?php


namespace app\controllers;


use app\models\Activity;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;

class ActivityController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class, //ACF
                'only' => ['index', 'view', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        //'actions' => ['logout'],
                        'roles' => ['admin'], // role with Rbac
                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['login', 'signup'],
//                        'roles' => ['?'], //isGuest    ['@'], - !isGuest  (without Rbac)
//                    ],
                ],
            ],
        ];
    }


    public function actionIndex($sort = false)
    {

//        $db = Yii::$app->db;
//        $rows = $db->createCommand('select * from activities')->queryAll();

//        $query = new Query();

//        $query->select('*')->from('activities');
        $query = Activity::find();

        if ($sort) {
            $query->orderBy("id desc");
        }
        $rows = $query->all();

        return $this->render('index', [
            'activities' => $rows
        ]);
    }

    /**
     * Просмотр определенного события
     * @return string
     */
    public function actionView($id)
    {

//        $model = new Activity([
//            'title' => 'Сотворение ДЗ',
//            'day_start' => '2019-11-26',
//            'day_end' => '2019-11-27',
//            'user_id' => 'id пользователя',
//            'description' => 'Сижу ночью , пилю дз',
//            'repeat' => true,
//            'blocked' => true,
//
//        ]);

        $db = Yii::$app->db;
        $model = $db->createCommand('select * from activities where id=:id', [
            ':id' => $id,
        ])->queryOne();

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
            // $model->attachments = UploadedFile::getInstance($model, 'attachments');

            if ($model->validate()) {
                $model->save();
//                $query = new QueryBuilder(Yii::$app->db);
//                $params =[];
//                $query->insert('activities', $model->attributes, $params);
                return "Success: " . VarDumper::export($model->attributes);
            } else {
                return "Failed: " . VarDumper::export($model->errors);
            }
        }
        return 'submit activity';
    }
}