<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="recover-result">

    <?php if( Yii::$app->session->hasFlash('errorEmail') ): ?>
        <div class="message" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('errorEmail'); ?>
        </div>
    <?php endif;?>

    <div class="blockParent col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8">
        <div class="row blockTitle">
            <h1 style="color:#fff;">Восстановить мой результат</h1>
        </div>
    <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => [
                'class' => 'form-horizontal',
                'style' => "margin-top:20px; margin-bottom:20px;"
            ],
        ]) ?>
    <?= $form->field($model, 'email', ['options' => ['style' => 'margin-right: 3spx; margin-left: 3spx;']])->label(Yii::t('common', 'Enter the email address you provided to receive the result')); ?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton(Yii::t('common', 'Send me a link with my result'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>