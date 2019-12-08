<?php


namespace app\models;


use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string'],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],
            [['username'], 'string', 'min' => 3],
            [['username'], 'string', 'min' => 6, 'max' => 32],
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User([
                'username' => $this->username,
                'access_token' => "{$this->username}--token",
//                'created_at' => time(),
//                'updated_at' => time(),
            ]);

            $user->generateAuthKey();
            $user->password = $this->password;

            if ($user->save()) {
                return \Yii::$app->user->login($user);
            }
            // если не прошла валидация
            return false;
        }
    }
}