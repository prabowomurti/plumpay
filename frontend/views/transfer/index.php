<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transfers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Send Money'), ['send'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'source.username',
                'label' => 'From',
            ],
            [
                'attribute' => 'destination.username',
                'label' => 'To',
            ],
            'amount',
            'message',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {return date('Y-m-d H:i:s', $model->created_at);}
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>