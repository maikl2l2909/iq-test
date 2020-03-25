<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php');

// @param bool $setCanonical true, try to create a canonical url and og url, action needs to have params
// @param bool $checkDb try to get from DB params, true: try to get info from DB if it doesn't find save a new field
// associated to current host + '/' + path, false: it just set the params give in the call. The db params has priority
// over the call function params. It does a merge
$setCanonical = false;
$checkDb = true;
Yii::$app->seotools->setMeta([/*'title' => \Yii::t('title','A good title for this page')*/], $setCanonical, $checkDb);
?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img class="brain" src="/img/brain3.png"><span><div class="pres">
                            <span class="reg">Международный&nbsp;реестр IQ</span>
                            <span class="stat">- Статистические данные о результатах</span>
                            <span class="sat">- Средний&nbsp;показатель: 100</span>
                            <span class="world">- Используется во всем мире</span>
                        </div></span>',
        'brandUrl' => '/' . Yii::$app->language,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]); ?>
    <?php echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav navbar-right'],
        'items' => [
            [
                'label'=>Yii::t('frontend', 'Language'),
                'items'=>array_map(function ($code) {
                    return [
                        'label' => Yii::$app->params['availableLocales'][$code],
                        'url' => ['/site/set-locale', 'locale' => $code],
                        'active' => Yii::$app->language === $code
                    ];
                }, array_keys(Yii::$app->params['availableLocales']))
            ]
        ]
    ]); ?>
    <?php echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => [
            ['label' => Yii::t('frontend', 'Take the Test'), 'url' => ['/' . Yii::$app->language]],
            ['label' => Yii::t('frontend', 'Recover my result'), 'url' => ['/' . Yii::$app->language . '/site/recover']],
        ]
    ]); ?>
    <?php NavBar::end(); ?>

    <?php echo $content ?>

</div>

    <footer>
        <div class="row">
            <div class="col-xs-12">
	    <span>
            <?php echo Html::a(date("Y") .' © iq-test-international.org', '/' . Yii::$app->language ); ?>
            <span>
            <?php echo Html::a('Контакты', '/' . Yii::$app->language . '/site/contact')?>
            <?php echo Html::a('Условия использования','/' . Yii::$app->language . '/site/conditions')?>
            </span>
        </span></div>
        </div>
    </footer>
<?php $this->endContent() ?>