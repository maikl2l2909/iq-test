<?php
/* @var $this yii\web\View */
/* @var $respondent \common\models\Respondent */
/* @var $result \common\models\Result */
/* @var $birthYears array */

use frontend\assets\FrontendAsset;
use dosamigos\chartjs\ChartJs;
use yii\widgets\ActiveForm;
use common\models\Respondent;
use yii\helpers\Html;

$this->title = Yii::$app->name;

$this->registerCssFile('@web/css/site-index.css', [
    'depends' => FrontendAsset::class
]);

$this->registerJsFile('js/test.js', ['depends' => FrontendAsset::class]);
?>

<style>
    .error-field {
        max-width: 300px;
        margin:0 0 0 5px;
    }

    #respondent-form label {
        width : 150px;
    }

    .res {
        display: flex;
    }

    .flag {
        border: 1px solid;
        margin-right: 8px;
        height: 40px;
    }

    #answers img:hover {
        cursor: pointer;
    }
</style>

<div class="glob" style="display: flex;">
    <div class="lastResults" style="width: 20%;">
        <h3>
            <?=Yii::t('frontend', 'Last 20 results')?>
        </h3>
        <div class="results">
            <?php foreach ($lastTwentyResults as $lastResult):?>
            <div class="res">
                <?= Html::img( isset($lastResult->respondent->country->photo_base_url) ? $lastResult->respondent->country->photo_base_url . $lastResult->respondent->country->photo_path : '/img/country-flags/laurent-drapeau-pirate.png', ['class' => 'flag']); ?>
                <div>
                    <div class="username"><?= $lastResult->respondent->name; ?></div>
                    <div>IQ : <b><?= $lastResult->iq; ?></b></div>
                    <div><?=  Yii::$app->formatter->asDate($lastResult->created_at, 'dd/MM/yy H:m');?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div style="width: 80%; position: relative;">
        <div class="start">
            <h1><?= Yii::t('frontend', 'Iq-test'); ?></h1>
            <img src="/img/golden.png">
            <p>Добро пожаловать в <?php echo Yii::t('frontend', 'Iq-test');?>.</p>
            <p class="bold">Перед началом теста, убедитесь, что&nbsp;окружающая Вас обстановка способствует&nbsp;сосредоточению.</p>
            <p>Мы оценим&nbsp;в ваших ответах на&nbsp;40 вопросов, способность к обучению, пониманию, формированию&nbsp;понятий,&nbsp;использованию&nbsp;информации и&nbsp;применению&nbsp;логики&nbsp;и&nbsp;разума.</p>
            <p class="bold">Конечный результат теста выдаст&nbsp;Ваш&nbsp;показатель&nbsp;IQ&nbsp;и вашу позицию по отношению к населению&nbsp;опираясь на&nbsp;несколько статистических данных.</p>
            <div class="center">
                <a id="startTest"
                   onclick="ym(61438681,'reachGoal','START_TEST'); gtag('event', 'start', { 'event_category': 'test'});"
                   class="btn">
                    <?= Yii::t('frontend', 'Run the test!');?>
                </a>
            </div>
        </div>

        <div class="test hidden">
            <h2 style="font-family:Arial;font-weight:normal;">Выберите недостающую фигуру.<span id="pos" class="pos">1/40</span></h2>
            <div id="question" class="prop" data-question="1"><img src="img/exos/ex1.png"></div>
            <div id="answers" style="padding: 0 25%;">
                <div style="display: flex; justify-content: space-between">
                    <div class="ans1"><span class="letter">a.</span><img data-ans="a" src="img/exos/ex1_a.png"></div>
                    <div class="ans2"><span class="letter">b.</span><img data-ans="b" src="img/exos/ex1_b.png"></div>
                    <div class="ans3"><span class="letter">c.</span><img data-ans="c" src="img/exos/ex1_c.png"></div>
                </div>
                <div style="margin-top:10px; display: flex; justify-content: space-between">
                    <div class="ans4"><span class="letter">d.</span><img data-ans="d" src="img/exos/ex1_d.png"></div>
                    <div class="ans5"><span class="letter">e.</span><img data-ans="e" src="img/exos/ex1_e.png"></div>
                    <div class="ans6"><span class="letter">f.</span><img data-ans="f" src="img/exos/ex1_f.png"></div>
                </div>
            </div>
        </div>

        <div class="inf hidden">
            <h2 class="center">Поздравляем, вы только что закончили тест!</h2>
            <img src="/img/golden.png">
            <p>Для того, чтобы&nbsp;издать&nbsp;ваш показатель&nbsp;и статистики&nbsp;(уровень&nbsp;IQ,&nbsp;позиции в соответствии с&nbsp;возрастом, сфере&nbsp;обучения и уровня образования),&nbsp;просим&nbsp;вас заполнитьследующую&nbsp;информацию:</p>
            <p class="err"></p>
            <?php $form = ActiveForm::begin(['options' => [
                'style' => 'display:flex; flex-direction:column;',
                'id' => 'respondent-form',
                'fieldClass' => false,
            ]]); ?>

            <?= $form->field($respondent, 'name', [
                'options' => ['class' => 'col-lg-10', 'style' => 'display:flex; align-items: center; margin-top: 3px;'],
            ])->textInput(['class' => '', 'style' => 'width: 230px;'])
                ->label(Yii::t('common', 'Username') . ' : ')
                ->error(['class' => 'error-field help-block']) ?>

            <?= $form->field($respondent, 'email', [
                'options' => ['class' => 'col-lg-10', 'style' => 'display:flex; align-items: center; margin-top: 3px;'],
            ])->textInput(['class' => '', 'style' => 'width: 230px;', 'type' => 'email'])
                ->label(Yii::t('common', 'Email') . ' : ')
                ->error(['class' => 'error-field help-block']) ?>

            <?= $form->field($respondent, 'gender', [
                'options' => ['class' => 'col-lg-10', 'style' => 'display:flex; align-items: center; margin-top: 3px;'],
            ])->dropDownList([Respondent::GENDER_MAN => 'man', Respondent::GENDER_WOMAN => 'woman'], ['prompt' => '', 'class' => '', 'style' => 'max-width: 230px; min-width:100px;'])
                ->label(Yii::t('common', 'Gender') . ' : ')
                ->error(['class' => 'error-field help-block']) ?>

            <?= $form->field($respondent, 'birth_year', [
                'options' => ['class' => 'col-lg-10', 'style' => 'display:flex; align-items: center; margin-top: 3px;'],
            ])->dropDownList($birthYears, ['prompt' => '', 'class' => '', 'style' => 'max-width: 230px; min-width:100px;'])
                ->label(Yii::t('common', 'Birth Year') . ' : ')
                ->error(['class' => 'error-field help-block']) ?>

            <?= $form->field($respondent, 'education', [
                'options' => ['class' => 'col-lg-10', 'style' => 'display:flex; align-items: center; margin-top: 3px;'],
            ])->dropDownList(\common\enums\Education::$list, ['prompt' => '', 'class' => '', 'style' => 'max-width: 230px; min-width:100px;'])
                ->label(Yii::t('common', 'Education') . ' : ')
                ->error(['class' => 'error-field help-block']) ?>

            <?= $form->field($respondent, 'education_level', [
                'options' => ['class' => 'col-lg-10', 'style' => 'display:flex; align-items: center; margin-top: 3px;'],
            ])->dropDownList(\common\enums\EducationLevel::$list, ['prompt' => '', 'class' => '', 'style' => 'max-width: 230px; min-width:100px;'])
                ->label(Yii::t('common', 'Education Level') . ' : ')
                ->error(['class' => 'error-field help-block']) ?>

            <?= $form->field($result, 'answers', ['template' => '{input}', 'options' => []])->hiddenInput()->label(false) ?>
            <?//= $form->field($result, 'duration', ['template' => '{input}', 'options' => []])->hiddenInput()->label(false) ?>

            <div class="clearfix"></div>
            <div class="form-group" style="display: flex; justify-content: center; margin-top: 20px;">
                <?= \yii\helpers\Html::submitButton(Yii::t('common', 'Validate!'), [
                    'class' => 'btn',
                    'style' => 'font-size: 18px;',
                    'onclick' => "ym(61438681,'reachGoal','END_TEST'); gtag('event', 'end', { 'event_category': 'test'});"
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="texts">
            <?php $seootolsRoute = Yii::$app->seotools->getRoute();
                $seotoolsMetaData = Yii::$app->seotools->getMeta($seootolsRoute);
                echo $seotoolsMetaData && isset($seotoolsMetaData['info']) ? $seotoolsMetaData['info'] : '';  ?>

            <div class="col-sm-12 stats">
                <div class="col-sm-12 col-md-6 stat">
                    <h3 class="center">Общее распределение и Международный&nbsp;уровень показателей&nbsp;IQ</h3>
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
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 stat">
                    <h3 class="center">Распределение по отношению к возрастной группе</h3>
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
                                'labels' => ["< 18 " . Yii::t('frontend', 'Years') ."", "18-39 " . Yii::t('frontend', 'Years') ."", "40-59 " . Yii::t('frontend', 'Years') ."", "59-79 " . Yii::t('frontend', 'Years') ."", "80 " . Yii::t('frontend', 'Years') ." >"],
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
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 stat">
                    <h3 class="center">Распределение относительно&nbsp;уровня образования</h3>
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
                                'labels' => [Yii::t('frontend', 'High school diploma'), '', '', '3 ' . Yii::t('frontend', 'years of higher education'), '', '', Yii::t('frontend', 'more 5 years of higher education')],
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
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 stat">
                    <h3 class="center">Распределение по отношению к области&nbsp;знаний</h3>
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
                                'labels' => [ Yii::t('frontend', 'High School'), Yii::t('frontend', 'Agriculture'), Yii::t('frontend', 'Architecture and urbanism'), Yii::t('frontend', 'Art and design'), Yii::t('frontend', 'Commercial and management'), Yii::t('frontend', 'Education'), Yii::t('frontend', 'Engineering and technology'), Yii::t('frontend', 'Geography and geology'), Yii::t('frontend', 'Letters and culture'), Yii::t('frontend', 'Languages and philology'), Yii::t('frontend', 'Law'), Yii::t('frontend', 'Math and Computer Science'), Yii::t('frontend', 'Medical sciences'), Yii::t('frontend', 'Natural Sciences'), Yii::t('frontend', 'Social sciences'), Yii::t('frontend', 'Communication and information')],
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
                                        ],
                                        'borderWidth' => 1,
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>