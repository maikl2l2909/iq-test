<?php

namespace common\models;

use yii\base\Model;

class RecoverResultForm extends Model
{
    public $email;
    public $token;

    public function rules()
    {
        return [
            ['email', 'email']
        ];
    }

}