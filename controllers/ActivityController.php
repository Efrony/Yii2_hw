<?php


namespace app\controllers;


use app\models\Activity;
use yii\data\ActiveDataProvider;
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
                'only' => ['index', 'view', 'edit', 'create', 'delete', 'submit'],
                'rules' => [
                    //  without Rbac
                    [
                        'allow' => true,
                        // 'actions' => ['login', 'signup'],
                        'roles' => ['@'], //!isGuest    ['?'], - isGuest
                    ],

                    // role with Rbac
//                    [
//                        'allow' => true,
//                        //'actions' => ['logout'],
//                        'roles' => ['admin'],
//                    ],

                ],
            ],
        ];
    }


    public function actionIndex()
    {

        $query = Activity::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'provider' => $provider
        ]);
    }

    /**
     * Просмотр определенного события
     * @return string
     */
    public function actionView($id)
    {
        $db = Yii::$app->db;
        $model = Activity::findOne($id);

        return $this->render('view', ['model' => $model]);
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

    public function actionEdit(int $id = null)
    {
        $model = $id ? Activity::findOne($id) : new Activity();
        return $this->render('edit', ['model' => $model]);
    }

    public function actionSubmit($id = null)
    {
        $model = $id ? Activity::findOne($id) : new Activity();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['activity/view', 'id' => $model->id]);
                //return "Success: " . VarDumper::export($model->attributes);
            }
            return $this->render('edit', ['model' => $model]);
            //return "Failed: " . VarDumper::export($model->errors);
        }
        return 'submit activity';
    }
}