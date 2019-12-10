<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activities}}`.
 */
class m191201_161526_create_activities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activities}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'day_start' => $this->string(),
            'day_end' => $this->string(),
            'user_id' => $this->integer(),
            'description' => $this->text(),
            'repeat' => $this->boolean(),
            'blocked' => $this->boolean(),
            // 'attachments'
        ]);

        // создание реляционной связи на позьзователей
        $this->addForeignKey(
          'fk_activity_user',
          'activity',
          'user_id',
          'user',
          'id',
          'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activities}}');
    }
}
