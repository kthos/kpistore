<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii2assets\pdfjs;
use frontend\controllers\KpiArchiveController;


/* @var $this yii\web\View */
/* @var $model frontend\models\KpiArchive */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kpi Archives'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kpi-archive-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!Yii::$app->user->isGuest){?> <!--เงื่อนไขถ้าไม่Loginก็ไม่เห็นปุ่ม-->
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
    <?php }?><!--เงื่อนไขถ้าไม่Loginก็ไม่เห็นปุ่ม-->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ref',
            'title',
            'description:ntext',
            //'covenant',
            //'docs:ntext',
            //['attribute'=>'covenant','value'=>$model->listDownloadFiles('covenant'),'format'=>'html'],//original code by dixonsatit 
            //['attribute'=>'docs','value'=>$model->listDownloadFiles('docs'),'format'=>'html'],//original code by dixonsatit 
            ['attribute'=>'covenant','value'=>$model->ViewPdf('covenant'),'format'=>'html',['target'=>'_blank']],//Edit by nont
            ['attribute'=>'docs','value'=>$model->ViewPdf('docs'),'format'=>'html'],//Edit by nont
            
            'start_date',
            'end_date',
            'success_date',
            'create_date',
        ],
    ]) ?>

<!--/****************************************************************/-->    
<?php
Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me'],
]);
echo \yii2assets\pdfjs\PdfJs::widget([
  //'url' => Url::base().'/downloads/manualStart_up.pdf'
  //'url' => Url::base().'/kpiarchive/'.$model->ref.'/d55a847e30b2cc59a631fdd412fddeae.pdf'
  'url' => Url::base().'/kpi-archive/pdfview'
]);

Modal::end();
?>
<!--/****************************************************************/-->   
    
    
    
    <div class="form-group">
       <?= Html::a(Yii::t('app','<i class="glyphicon glyphicon-plus"></i> '.'OK')
               , ['/kpi-archive/index']
               , ['class' => 'btn btn-success'.' btn-lg btn-block'])?>
    </div>


</div>
