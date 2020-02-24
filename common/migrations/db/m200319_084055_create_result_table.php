<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%result}}`.
 */
class m200319_084055_create_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%result}}', [
            'id' => $this->primaryKey(),
            'iq' => $this->integer(),
            'respondent_id' => $this->integer(),
            'answers' => $this->json()->notNull(),
            'token' => $this->string()->notNull()->unique(),
            'payed_status' => $this->boolean(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex('idx-result-respondent_id', '{{%result}}', 'respondent_id');
        $this->addForeignKey('fk-result-respondent_id', '{{%result}}', 'respondent_id', '{{%respondent}}', 'id', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%result}}');
    }
}
