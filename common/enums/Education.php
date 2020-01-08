<?php

namespace common\enums;

use yii2mod\enum\helpers\BaseEnum;

class Education extends BaseEnum
{
    const HIGH_SCHOOL = 1;
    const AGRICULTURE = 2;
    const ARCHITECTURE = 3;
    const ART = 4;
    const BUSINESS = 5;
    const EDUCATION = 6;
    const ENGINEERING = 7;
    const GEOGRAPHY = 8;
    const HUMANITIES = 9;
    const LANGUAGES = 10;
    const LAW = 11;
    const MATHS = 12;
    const MEDICAL = 13;
    const NATURAL = 14;
    const SOCIAL = 15;
    const COMMUNICATION = 16;

    public static $messageCategory = 'common';

    public static $list = [
        self::HIGH_SCHOOL => 'High School',
        self::AGRICULTURE => 'Agriculture',
        self::ARCHITECTURE => 'Architecture and urbanism',
        self::ART => 'Art and design',
        self::BUSINESS => 'Commercial and management',
        self::EDUCATION => 'Education',
        self::ENGINEERING => 'Engineering and technology',
        self::GEOGRAPHY => 'Geography and geology',
        self::HUMANITIES => 'Letters and culture',
        self::LANGUAGES => 'Languages and philology',
        self::LAW => 'Law',
        self::MATHS => 'Math and Computer Science',
        self::MEDICAL => 'Medical sciences',
        self::NATURAL => 'Natural Sciences',
        self::SOCIAL => 'Social sciences',
        self::COMMUNICATION => 'Communication and information',
    ];
}
