<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "respondent".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int|null $gender
 * @property int|null $birth_year
 * @property int $education
 * @property int $education_level
 * @property resource|null $ip
 * @property integer $country_id
 *
 * @property Result[] $results
 */
class Respondent extends \yii\db\ActiveRecord
{
    const GENDER_MAN = 1;
    const GENDER_WOMAN = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respondent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'education', 'education_level'], 'required'],
            [['gender', 'birth_year', 'education', 'education_level', 'country_id'], 'integer'],
            [['name', 'email', 'ip'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'gender' => 'Gender',
            'birth_year' => 'Birth Year',
            'education' => 'Education',
            'education_level' => 'Education Level',
            'ip' => 'Ip',
            'country_id' => 'Country',
        ];
    }

    /**
     * Gets query for [[Results]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResults()
    {
        return $this->hasMany(Result::class, ['respondent_id' => 'id']);
    }

    public function getResult()
    {
        return $this->hasOne(Result::class, ['respondent_id' => 'id']);
    }

    /**
     * @return array
     * */
    public static function allowYear()
    {
        $allowYear = (int)(new \DateTime())->format('Y') - 12;
        while ($allowYear >= 1930) {
            $birthYears[$allowYear] = $allowYear;
            $allowYear--;
        };

        return $birthYears ?? [];
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}
