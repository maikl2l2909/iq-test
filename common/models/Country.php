<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string $isoCode Two-letter country code (ISO 3166-1 alpha-2)
 * @property string|null $photo_base_url
 * @property string|null $photo_path
 *
 * @property Respondent[] $respondents
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'isoCode'], 'required'],
            [['name', 'photo_base_url', 'photo_path'], 'string', 'max' => 255],
            [['isoCode'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'isoCode' => 'Iso Code',
            'photo_base_url' => 'Photo Base Url',
            'photo_path' => 'Photo Path',
        ];
    }

    /**
     * Gets query for [[Respondents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespondents()
    {
        return $this->hasMany(Respondent::class, ['country_id' => 'id']);
    }
}
