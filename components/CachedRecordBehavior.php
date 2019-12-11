<?php

namespace app\components;

use app\models\Activity;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;

class CachedRecordBehavior extends Behavior
{
    public $prefix;
    public function events()
    {
        return [
           ActiveRecord::EVENT_AFTER_UPDATE => 'clearcache',
        ];
    }

    private function buildKey()
    {
        return "{$this->prefix}_{$this->owner->id}";  //owner в данном случае это наш ActiveRecord, в котором мы указали поведение
    }

    public function clearcache()
    {
        Yii::$app->cache->delete($this->buildKey());
    }

    public function cache()
    {
        if (Yii::$app->cache->exists($this->buildKey())) {
            return  Yii::$app->cache->get($this->buildKey());
        } else {
            Yii::$app->cache->set($this->buildKey(), $this->owner);
            return $this->owner;
        }
    }
}