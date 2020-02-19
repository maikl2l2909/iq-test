<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country}}`.
 */
class m200319_075936_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'isoCode' => $this->string(3)->notNull()->comment('Two-letter country code (ISO 3166-1 alpha-2)'),
            'photo_base_url' => $this->string(255),
            'photo_path' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }
}
