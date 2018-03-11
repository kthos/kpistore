<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\KpiArchive */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kpi Archives'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kpi-archive-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ref',
            'title',
            'description:ntext',
            'covenant',
            'docs:ntext',
            //['attribute'=>'covenant','value'=>$model->listDownloadFiles('covenant'),'format'=>'html'],
            //['attribute'=>'docs','value'=>$model->listDownloadFiles('docs'),'format'=>'html'],
            'start_date',
            'end_date',
            'success_date',
            'create_date',
        ],
    ]) ?>
    
    
    <div class="form-group">
       <?= Html::a(Yii::t('app','<i class="glyphicon glyphicon-plus"></i> '.'OK')
               , ['/kpi-archive/index']
               , ['class' => 'btn btn-success'.' btn-lg btn-block'])?>
    </div>


</div>
