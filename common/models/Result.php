<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "result".
 *
 * @property int $id
 * @property int|null $iq
 * @property int|null $respondent_id
 * @property string $answers
 * @property string $token
 * @property int|null $payed_status
 * @property int|null $created_at
 *
 * @property Respondent $respondent
 */
class Result extends \yii\db\ActiveRecord
{
    const NOT_PAID = 0;
    const PAID = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'result';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ]
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->iq = ceil(self::calculationIQ($this->answers));
        $this->token = $token = implode('~', [
            (Yii::$app instanceof \yii\web\Application) ? Yii::$app->security->maskToken(Yii::$app->request->userIP) : '12345678901',
            Yii::$app->security->maskToken($this->respondent->email),
            Yii::$app->security->maskToken((new \DateTime())->format('U')),
        ]);

        return $this->validate() ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iq', 'respondent_id', 'payed_status', 'created_at'], 'integer'],
            [['payed_status'], 'default', 'value' => self::NOT_PAID],
            [['answers', 'token'], 'required'],
            [['answers'], 'safe'],
            [['token'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['respondent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Respondent::class, 'targetAttribute' => ['respondent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iq' => 'Iq',
            'respondent_id' => 'Respondent ID',
            'answers' => 'Answers',
            'token' => 'Token',
            'payed_status' => 'Payed Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Respondent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespondent()
    {
        return $this->hasOne(Respondent::class, ['id' => 'respondent_id']);
    }

    private static function calculationIQ($answers)
    {
        $answers = Json::decode($answers);

        $rightAnswers = array_intersect_assoc($answers, self::rightAnswers()); // массив правильных ответов пользователя

        return count($rightAnswers) * 1.5 + 85;
    }

    private static function rightAnswers()
    {
        // a, b, c, d, e, f
        return [
            1 => 'f',
            2 => 'f',
            3 => 'd',
            4 => 'b',
            5 => 'e',
            6 => 'a',
            7 => 'c',
            8 => 'f',
            9 => 'd',
            10 => 'f',
            11 => 'c',
            12 => 'e',
            13 => 'b',
            14 => 'd',
            15 => 'f',
            16 => 'd',
            17 => 'b',
            18 => 'a',
            19 => 'd',
            20 => 'f',
            21 => 'b',
            22 => 'd',
            23 => 'b',
            24 => 'd',
            25 => 'b',
            26 => 'c',
            27 => 'd',
            28 => 'a',
            29 => 'e',
            30 => 'd',
            31 => 'e',
            32 => 'c',
            33 => 'f',
            34 => 'd',
            35 => 'e',
            36 => 'b',
            37 => 'a',
            38 => 'f',
            39 => 'a',
            40 => 'c',
        ];
    }
}
