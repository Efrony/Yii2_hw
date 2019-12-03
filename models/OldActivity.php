<?php


namespace app\models;


use yii\base\Model;

class OldActivity extends Model
{
    public $title;
    public $day_start;
    public $day_end;
    public $user_id;
    public $description;
    public $repeat = false;
    public $blocked = true;
    public $attachments;

    /**
     * Правила валидации данных модели
     * @return array
     */
    public function  rules()
    {
        return [
            [['title', 'day_start', 'day_end', 'user_id', 'description'], 'required'],
            [['title', 'description'], 'string'],
            [['title'], 'string', 'min' => 1, 'max' => 150 ],
            [['day_start', 'day_end'], 'date', 'format' => 'php:Y-m-d'],
            [['user_id'], 'integer'],
            [['repeat', 'blocked'], 'boolean'],
            [['attachments'], 'file', 'maxFiles' => 3],
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
}