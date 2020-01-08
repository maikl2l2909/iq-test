<?php

namespace common\enums;

use yii2mod\enum\helpers\BaseEnum;

class EducationLevel extends BaseEnum
{
    const NONE = 0;
    const HIGH_SCHOOL = 1;
    const HIGHER_EDUCATION_2 = 2;
    const HIGHER_EDUCATION_3 = 3;
    const HIGHER_EDUCATION_4 = 4;
    const HIGHER_EDUCATION_5 = 5;
    const HIGHER_EDUCATION_MORE = 6;

    public static $messageCategory = 'common';

    public static $list = [
        self::NONE => 'No diploma',
        self::HIGH_SCHOOL => 'High School',
        self::HIGHER_EDUCATION_2 => '2 years of higher education',
        self::HIGHER_EDUCATION_3 => '3 years of higher education',
        self::HIGHER_EDUCATION_4 => '4 years of higher education',
        self::HIGHER_EDUCATION_5 => '5 years of higher education',
        self::HIGHER_EDUCATION_MORE => 'more 5 years of higher education',
    ];
}
