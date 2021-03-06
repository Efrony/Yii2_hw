<?php


namespace app\controllers;


use app\models\Activity;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\PageCache;
use yii\caching\DbDependency;

class ActivityController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class, //ACF
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'edit', 'delete', 'submit'],
                        'roles' => ['@'], //!isGuest    ['?'], - isGuest
                    ],
                ],
            ],

            // кеширование страницы index
            [
                'class' => PageCache::class,
                'only' => ['index'],
                'duration' => 120,
                'dependency' => [
                    'class' => DbDependency::class,
                    'sql' => 'SELECT COUNT(*) FROM activity',
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $query = Activity::find();

        //добавим условие  на выборку  по пользователю. если это не менеджер
        if(!Yii::$app->user->can('admin')) {
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }
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
        $cacheKey = "activity_{$id}";

        if (Yii::$app->cache->exists($cacheKey)) {
            $model = Yii::$app->cache->get($cacheKey);
        } else {
            $model = Activity::findOne($id);
            Yii::$app->cache->set($cacheKey, $model);
        }

        // записи может просматривать только создатель или админ
        if (Yii::$app->user->can('admin') || $model->user_id == Yii::$app->user->id) {
            return $this->render('view', ['model' => $model]);
        }
        throw new NotFoundHttpException();

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
        $model = $id ? Activity::findOne($id) : new Activity([
            'user_id' => Yii::$app->user->id,
        ]);
        //обновлять записи может только создатель, менеджер или админ
        if ($model->user_id == Yii::$app->user->id || Yii::$app->user->can('manager') || Yii::$app->user->can('admin'))
        {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->save();
                    return $this->redirect(['activity/view', 'id' => $model->id]);
                    //return "Success: " . VarDumper::export($model->attributes);
                }
                return $this->render('edit', ['model' => $model]);
                //return "Failed: " . VarDumper::export($model->errors);
            }
        }
         throw new NotFoundHttpException();
    }
}