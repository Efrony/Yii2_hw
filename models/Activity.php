<?php


namespace app\models;


use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;


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
            [['user_id'], 'integer'],
            [['repeat', 'blocked'], 'boolean'],
//            [['attachments'], 'file', 'maxFiles' => 3],
        ];
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

}