<?php


namespace app\models;


use app\components\CachedRecordBehavior;
use yii\behaviors\TimestampBehavior;
use yii\caching\Cache;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $access_token
 * @property int $created_at
 * @property int $updated_at
 *
 * @property-write $password -> setPassword()
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Набор поведений
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => CachedRecordBehavior::class,
                'prefix' => 'user',
            ]
//            [
//                'class' => TimestampBehavior::class,
//                'updatedAtAttribute' => 'last_change_at',
//            ]
        ];
    }

    public static function tableName()
    {
        return 'users';
    }


    public static function findIdentity($id)
    {
        //select * from 'users' where 'id' = $id
        return self::findOne(['id' => $id]);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }


    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        return $this->auth_key;
    }


    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }
}