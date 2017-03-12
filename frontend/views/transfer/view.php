<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Transfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transfers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'source.username',
            'destination.username',
            'amount',
            'status',
            'message',
            'description:ntext',
            [
                'attribute' => 'created_at',
                'value' => date('Y-m-d H:i:s', $model->created_at)
            ],
        ],
    ]) ?>

</div>