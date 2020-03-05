<?php
/* @var $this yii\web\View */
/* @var $respondent \common\models\Respondent */
/* @var $result \common\models\Result */
/* @var $birthYears array */

use frontend\assets\FrontendAsset;
use dosamigos\chartjs\ChartJs;
use common\enums\EducationLevel;
use common\enums\Education;

$this->title = Yii::$app->name;

$this->registerCssFile('@web/css/site-index.css', [
    'depends' => FrontendAsset::class
]);

?>

<style>
    #respondent-form label {
        width : 150px;
    }

    #answers img:hover {
        cursor: pointer;
    }
</style>

<div class="glob" style="display: flex;">

    <div style="width: 80%; position: relative;">

        <div class="col-xs-offset-1 col-xs-10">
            <h1>Результат теста&nbsp;IQ</h1>
            <img class="golden" src="/img/golden.png">
            <p class="bold">Поздравляю <?= $resultRespondent->respondent->name ?> !</p>
            <p>Тест&nbsp;IQ, что вы прошли&nbsp;представляет собой эволюцию&nbsp;концепции прогрессивных матриц&nbsp;Равена. Они&nbsp;предназначены для диагностики уровня&nbsp;интеллектуального&nbsp;развития и оценивания&nbsp;логики,&nbsp;способности&nbsp;трезво&nbsp;рассуждать и воспринимать сложность&nbsp;а также&nbsp;способность&nbsp;запоминать&nbsp;и воспроизводить&nbsp;образцы информации, которую иногда называют репродуктивной способностью.</p>
            <p>Прежде всего, следует помнить, что уровень среднего&nbsp;IQ&nbsp;фиксирован&nbsp;на&nbsp;100&nbsp;по историческим причинам.&nbsp;Тест, что вы пройдете&nbsp;был разработан таким образом, чтобы средний&nbsp;показатель&nbsp;кандидатов&nbsp;был равен&nbsp;100.&nbsp;Впоследствии,&nbsp;каждый кандидат,&nbsp;в зависимости от&nbsp;полученного им&nbsp;результата может сравнить&nbsp;его&nbsp;со статистическими данными по различным параметрам.</p>
            <p>По результату&nbsp;теста,&nbsp;который&nbsp;вы только что завершили, <b>ваш&nbsp;IQ&nbsp;равен <?= $resultRespondent->iq; ?></b>.</p>
            <p>Этот показатель&nbsp;IQ&nbsp;является оценкой. Ваша оценка может варьировать в зависимости от формы и условий, при которых вы проходили&nbsp;тест.</p>
        </div>

        <div class="texts">
            <div class="col-sm-12 stats">
                <div class="col-sm-12 col-md-6 stat">
                    <h2 class="center">Общее распределение и Международный&nbsp;уровень показателей&nbsp;IQ</h2>
                    <div class="col-xs-12"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <?= ChartJs::widget([
                            'type' => 'bar',
                            'options' => [
                                'height' => 400,
                                'width' => 400
                            ],
                            'clientOptions' => [
                                'scales' => [
                                    'yAxes' => [[
                                        'ticks' => [
                                            'beginAtZero' => true,
                                        ]
                                    ]],
                                ],
                            ],
                            'data' => [
                                'labels' => ["- de 70", "70-79", "80-89", "90-109", "110-119", "120-129", "130+"],
                                'datasets' => [
                                    [
                                        'data' => $generalDistributionIqData,
                                        'label' =>  "% Населения",
                                        'backgroundColor' => [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        'borderColor' => [
                                            'rgba(255,99,132,1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        'borderWidth' => 1,
                                    ]
                                ]
                            ]
                        ]); ?>
                        <div class="col-xs-offset-1 col-xs-10 info">Вы&nbsp;принадлежите к <?php echo 100 - $percentageToOtherResults . '%'; if ($respondentIq > 120) { echo " самых умных"; } ?> людей мира. Вы умнее, чем <?php echo $percentageToOtherResults;?>% населения.</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 stat">
                    <h2 class="center">Распределение по отношению к возрастной группе</h2>
                    <div class="col-xs-12"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <?= ChartJs::widget([
                            'type' => 'bar',
                            'options' => [
                                'height' => 400,
                                'width' => 400
                            ],
                            'clientOptions' => [
                                'scales' => [
                                    'yAxes' => [[
                                        'ticks' => [
                                            'beginAtZero' => true,
                                        ]
                                    ]],
                                ],
                            ],
                            'data' => [
                                'labels' => ["< 18 " . Yii::t('frontend', 'Years') ."", "18-39 " . Yii::t('frontend', 'Years') ."", "40-59 " . Yii::t('frontend', 'Years') ."", "59-79 " . Yii::t('frontend', 'Years') ."", "80 " . Yii::t('frontend', 'Years') ." >", Yii::t('frontend', 'You')],
                                'datasets' => [
                                    [
                                        'data' => $ageGroupData,
                                        'label' =>  "Средний показатель IQ",
                                        'backgroundColor' => [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        'borderColor' => [
                                            'rgba(255,99,132,1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        'borderWidth' => 1,
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                        <div class="col-xs-offset-1 col-xs-10 info">Вы&nbsp;принадлежите к <?php echo 100 - $percentageAge . '%'; if ($respondentIq > 120) { echo " самых умных"; } ?>  людей вашего возраста. Вы умнее, чем <?php echo $percentageAge;?>% людей в вашем возрасте.</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 stat">
                    <h2 class="center">Распределение относительно&nbsp;уровня образования</h2>
                    <div class="col-xs-12"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <?= ChartJs::widget([
                            'type' => 'bar',
                            'options' => [
                                'height' => 400,
                                'width' => 400,
                            ],
                            'clientOptions' => [
                                'scales' => [
                                    'yAxes' => [[
                                        'ticks' => [
                                            'beginAtZero' => true,
                                        ]
                                    ]],
                                ],
                            ],
                            'data' => [
                                'labels' => [Yii::t('frontend', 'High school diploma'), '', '', '3 ' . Yii::t('frontend', 'years of higher education'), '', '', Yii::t('frontend', 'more 5 years of higher education'), Yii::t('frontend', 'You')],
                                'datasets' => [
                                    [
                                        'data' => $educationLevelData,
                                        'label' =>  "Средний показатель IQ",
                                        'backgroundColor' => [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(205, 40, 64, 0.2)'
                                        ],
                                        'borderColor' => [
                                            'rgba(255,99,132,1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
                                            'rgba(205, 40, 64, 1)'
                                        ],
                                        'borderWidth' => 1,
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                        <div class="col-xs-offset-1 col-xs-10 info">Вы принадлежите к <?php echo 100 - $percentageEducationLevel . '%'; if ($respondentIq > 120) { echo " самых умных"; }?> людей вашего уровня образования (<?php echo EducationLevel::getLabel($resultRespondent->respondent->education_level)?>). Вы умнее, чем <?php echo $percentageEducationLevel;?>% людей вашего уровня образования.</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 stat">
                    <h2 class="center">Распределение по отношению к области знаний</h2>
                    <div class="col-xs-12"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <?= ChartJs::widget([
                            'type' => 'horizontalBar',
                            'options' => [
                                'height' => 400,
                                'width' => 400
                            ],
                            'clientOptions' => [
                                'scales' => [
                                    'xAxes' => [[
                                        'ticks' => [
                                            'beginAtZero' => true,
                                            'min' => 75,
                                        ]
                                    ]],
                                ],
                            ],
                            'data' => [
                                'labels' => [ Yii::t('frontend', 'High School'), Yii::t('frontend', 'Agriculture'), Yii::t('frontend', 'Architecture and urbanism'), Yii::t('frontend', 'Art and design'), Yii::t('frontend', 'Commercial and management'), Yii::t('frontend', 'Education'), Yii::t('frontend', 'Engineering and technology'), Yii::t('frontend', 'Geography and geology'), Yii::t('frontend', 'Letters and culture'), Yii::t('frontend', 'Languages and philology'), Yii::t('frontend', 'Law'), Yii::t('frontend', 'Math and Computer Science'), Yii::t('frontend', 'Medical sciences'), Yii::t('frontend', 'Natural Sciences'), Yii::t('frontend', 'Social sciences'), Yii::t('frontend', 'Communication and information'), Yii::t('frontend', 'You')],
                                'datasets' => [
                                    [
                                        'data' => $educationData,
                                        'label' =>  "Средний показатель IQ",
                                        'backgroundColor' => [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(205, 40, 64, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(205, 40, 64, 0.2)',
                                            'rgba(205, 40, 64, 0.2)'
                                        ],
                                        'borderColor' => [
                                            'rgba(255,99,132,1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
                                            'rgba(205, 40, 64, 1)',
                                            'rgba(255,99,132,1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)',
                                            'rgba(205, 40, 64, 1)',
                                            'rgba(205, 40, 64, 1)',
                                        ],
                                        'borderWidth' => 1,
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                        <div class="col-xs-offset-1 col-xs-10 info">Вы принадлежите к <?php echo 100 - $percentageEducation . '%'; if ($respondentIq > 120) { echo " самых умных"; }?> людей в вашей сфере знания (<?php echo Education::getLabel($resultRespondent->respondent->education);?>). Вы умнее, чем <?php echo $percentageEducation;?>% людей принадлежащих вашей области знаний.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>