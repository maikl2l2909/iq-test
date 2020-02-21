<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%respondent}}`.
 */
class m200319_080123_create_respondent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%respondent}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'gender' => $this->integer(),
            'birth_year' => $this->integer(),
            'education' => $this->integer()->notNull(),
            'education_level' => $this->integer()->notNull(),
            'ip' => 'VARBINARY(255)',
            'country_id' => $this->integer(),
        ]);

        $this->createIndex('idx-respondent-country_id', '{{%respondent}}', 'country_id');
        $this->addForeignKey('fk-respondent-country_id', '{{%respondent}}', 'country_id', '{{%country}}', 'id', 'set null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%respondent}}');
    }
}
