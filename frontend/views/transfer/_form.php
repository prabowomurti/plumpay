<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transfer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'destination_username')->textInput() ?>    

    <?= $form->field($model, 'amount')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>