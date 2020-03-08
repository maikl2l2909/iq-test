<?php


namespace common\models;


use yii\base\Model;
use Yii;

class GraphicsData extends Model
{
    public function generalDistributionIqData()
    {
        $generalDistributionIqData = Yii::$app->db->createCommand('
            SELECT  (SELECT ROUND(COUNT(*)/(SELECT COUNT(*) FROM `result`)*100) FROM `result` WHERE iq < 70) as \'70\', 
                (SELECT ROUND(COUNT(*)/(SELECT COUNT(*) FROM `result`)*100) FROM `result` WHERE iq >= 70 AND iq < 80) as \'80\',
                (SELECT ROUND(COUNT(*)/(SELECT COUNT(*) FROM `result`)*100) FROM `result` WHERE iq >= 80 AND iq < 90) as \'90\',
                (SELECT ROUND(COUNT(*)/(SELECT COUNT(*) FROM `result`)*100) FROM `result` WHERE iq >= 90 AND iq < 110) as \'100\',
                (SELECT ROUND(COUNT(*)/(SELECT COUNT(*) FROM `result`)*100) FROM `result` WHERE iq >= 110 AND iq < 120) as \'120\',
                (SELECT ROUND(COUNT(*)/(SELECT COUNT(*) FROM `result`)*100) FROM `result` WHERE iq >= 120 AND iq < 130) as \'130\',
                (SELECT ROUND(COUNT(*)/(SELECT COUNT(*) FROM `result`)*100) FROM `result` WHERE iq >= 130) as \'140\'
            FROM result')->queryOne();
        return $generalDistributionIqData;
    }

    public function ageGroupData()
    {
        $year = date('Y');
        $ageGroupData = Yii::$app->db->createCommand('
            SELECT
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result`
                                    on respondent.id = result.respondent_id
                 WHERE birth_year > ' . ($year - 18) . ') as \'<18\',
            
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result`
                                    on respondent.id = result.respondent_id
                 WHERE birth_year >= ' . ($year - 39) . ' AND birth_year <= ' . ($year - 18) . ') as \'18-39\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result`
                                    on respondent.id = result.respondent_id
                 WHERE birth_year >= ' . ($year - 59) . ' AND birth_year <= ' . ($year - 40) . ') as \'40-59\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result`
                                    on respondent.id = result.respondent_id
                 WHERE birth_year >= ' . ($year - 79) . ' AND birth_year <= ' . ($year - 60) . ') as \'60-79\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result`
                                    on respondent.id = result.respondent_id
                 WHERE birth_year <= ' . ($year - 80) . ') as \'>80\'
            
            FROM respondent')->queryOne();

        return $ageGroupData;
    }

    public function educationLevelData()
    {
        $educationLevelData = Yii::$app->db->createCommand('
            SELECT
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education_level = 0) as \'No diploma\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education_level = 1) as \'High School\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education_level = 2) as \'2 years of higher education\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education_level = 3) as \'3 years of higher education\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education_level = 4) as \'4 years of higher education\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education_level = 5) as \'5 years of higher education\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education_level = 6) as \'more 5 years of higher education\'
            
            FROM respondent
            ')->queryOne();
        return $educationLevelData;
    }

    public function educationData()
    {
        $educationData = Yii::$app->db->createCommand('
            SELECT
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 1) as \'High School\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 2) as \'Agriculture\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 3) as \'Architecture and urbanism\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 4) as \'Art and design\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 5) as \'Commercial and management\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 6) as \'Education\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 7) as \'Engineering and technology\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 8) as \'Geography and geology\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 9) as \'Letters and culture\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 10) as \'Languages and philology\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 11) as \'Law\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 12) as \'Math and Computer Science\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 13) as \'Medical sciences\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 14) as \'Natural Sciences\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 15) as \'Social sciences\',
            
                (SELECT ROUND(AVG(iq))
                 FROM `respondent`
                          LEFT JOIN `result` on respondent.id = result.respondent_id
                 WHERE education = 16) as \'Communication and information\'
            
            FROM respondent')->queryOne();

        return $educationData;
    }

    public function percentageToOtherResults($iq)
    {
        $count = Result::find()
            ->count();
        $countLess = Result::find()
            ->where(['<', 'iq', $iq])
            ->count();

        return round($countLess * 100 / $count);
    }

    public function percentageAge($birthYear, $iq)
    {
        $birthYear = date('Y') - $birthYear;
        for($i = 80; 20 <= $i ; $i -= 20)
        {
            if ($birthYear < 18) // < 18
            {
                $count = Respondent::find()->where(['>', 'birth_year', date("Y") - 18])->count();
                $countLess = Respondent::find()->joinWith('results')->andWhere(['>', 'birth_year', date("Y") - 18])->andWhere(['<', 'iq', $iq])->count();

                return round($countLess * 100 / $count);
            }
            elseif ($birthYear >= 80) // > 80
            {
                $count = Respondent::find()
                    ->where(['<=', 'birth_year', (date("Y") - 80)])
                    ->count();
                $countLess = Respondent::find()
                    ->joinWith('results')
                    ->andWhere(['<=', 'birth_year', (date("Y") - 80)])
                    ->andWhere(['<', 'iq', $iq])
                    ->count();

                return round($countLess * 100 / $count);
            }
            elseif
            ($birthYear == 18 || $birthYear == 19) { // 18, 19
                $count = Respondent::find()
                    ->andWhere(['>', 'birth_year', (date("Y") - 40)])
                    ->andWhere(['<=', 'birth_year', (date("Y") - 18)])
                    ->count();
                $countLess = Respondent::find()
                    ->joinWith('results')
                    ->andWhere(['>', 'birth_year', (date("Y") - 40)])
                    ->andWhere(['<=', 'birth_year', (date("Y") - 18)])
                    ->andWhere(['<', 'iq', $iq])
                    ->count();

                return round($countLess * 100 / $count);
            }
            elseif($birthYear >= $i) // 18 - 39, 40 - 59, 60 - 79
            {
                $count = Respondent::find()
                    ->andWhere(['>', 'birth_year', (date("Y") - $i - 20)])
                    ->andWhere(['<=', 'birth_year', (date("Y") - ($i == 20 ? 18 : $i))])
                    ->count();
                $countLess = Respondent::find()
                    ->joinWith('results')
                    ->andWhere(['>', 'birth_year', (date("Y") - $i - 20)])
                    ->andWhere(['<=', 'birth_year', (date("Y") - ($i == 20 ? 18 : $i))])
                    ->andWhere(['<', 'iq', $iq])
                    ->count();

                return round($countLess * 100 / $count);
            }
        }
    }

    public function percentageEducationLevel($educationLevel, $iq)
    {
        $count = Respondent::find()
            ->where(['education_level' => $educationLevel])
            ->count();

        $countLess = Respondent::find()
            ->joinWith('results')
            ->andWhere(['education_level' => $educationLevel])
            ->andWhere(['<', 'iq', $iq])
            ->count();

        return round($countLess * 100 / $count);
    }

    public function percentageEducation($education, $iq)
    {
        $count = Respondent::find()
            ->where(['education' => $education])
            ->count();

        $countLess = Respondent::find()
            ->joinWith('results')
            ->andWhere(['education' => $education])
            ->andWhere(['<', 'iq', $iq])
            ->count();

        return round($countLess * 100 / $count);
    }

}