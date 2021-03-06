<?php


namespace app\models;


use app\components\CachedRecordBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Url;


/**
 * Class Activity
 * @package app\models
 *
 * @property-read User $user
 */
class Activity extends ActiveRecord
{
    public function behaviors()
    {
        return [
            //BlameableBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'user_id',
            ],
            TimestampBehavior::class,
            [
                'class' => CachedRecordBehavior::class,
                'prefix' => 'activity',
            ]
        ];
    }

    public static function tableName()
    {
        return 'activities';
    }

    /**
     * Правила валидации данных модели
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'day_start', 'description'], 'required'], //убрали 'user_id'
            [['title', 'description'], 'string'],
            [['title'], 'string', 'min' => 1, 'max' => 150],
            [['day_start', 'day_end'], 'date', 'format' => \Yii::$app->params['dateFormat']],
            ['day_end', 'default', 'value' => function () {
                return $this->day_start;
            }],
            ['day_end', 'validateDate'],
            [['user_id'], 'integer'],
            [['repeat', 'blocked'], 'boolean'],
//            [['attachments'], 'file', 'maxFiles' => 3],
        ];
    }

    public function validateDate($attr)
    {
        $start = strtotime($this->day_start);
        $end = strtotime($this->{$attr});

        if ($start && $end) {
            if ($end < $start) {
                $this->addError($attr, 'Дата окончания не может быть раньше даты начала');
            }
        }
    }

    /**
     * Называние полей модели
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название события',
            'day_start' => 'Дата начала события',
            'day_end' => 'Дата окончания события',
            'user_id' => 'Пользователь',
            'description' => 'Описание события',
            'repeat' => 'Повторять событие',
            'blocked' => 'Другие события в этот день не отображать',
            'attachments' => 'Прикрепленные файлы',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function findOne($condition){
        if(Yii::$app->cache->exists("activity_".$condition)){
            Yii::info("Значение найдено в кэше");
            return Yii::$app->cache->get("activity_".$condition);
        }
        else{
            Yii::info("Значение найдено в БД");
            $result = parent::findOne($condition);
            Yii::$app->cache->set("activity_".$condition, $result);
            return $result;
        }
    }

    /**
     * Преобразование в массив для календаря
     * @return array
     */
    public function toEvent()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->day_start,
            'end' => $this->day_end,
            'url' => Url::to(['/activity/view', 'id' => $this->id]),
        ];
    }
}