<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Transfer */

$this->title = Yii::t('app', 'Send Money');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transfers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>