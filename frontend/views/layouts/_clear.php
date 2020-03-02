<?php
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-60574599-7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-60574599-7');
    </script>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php // Yandex.Metrika counter ?>
<script type="text/javascript"><?php include_once("js/yandexmetrika.js") ?></script>
<noscript><div><img src="https://mc.yandex.ru/watch/39110770" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<?php // /Yandex.Metrika counter ?>
    <?php echo $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
