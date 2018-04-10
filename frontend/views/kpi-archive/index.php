<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'คลังตัวชี้วัด');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kpi-archive-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'เพิ่มตัวชี้วัด'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'ref',
            'title',
            'description:ntext',
            //'covenant',
            //'docs:ntext',
            //'start_date',
            //'end_date',
            //'success_date',
            'create_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    
    
</div>
