<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\KpiArchive */

$this->title = Yii::t('app', 'เพิ่มตัวชี้วัด');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'เพิ่มตัวชี้วัด'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kpi-archive-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
