<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Freelance */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="freelance-form">
    

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

     <?= $form->field($model, 'ref')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?=$form->field($model, 'covenant')
        //->textInput(['maxlength' => 100])
          ->widget(kartik\file\FileInput::className(),[
             //'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                'initialPreview'=>[],
                'allowedFileExtensions'=>['pdf'],
                'showPreview' => true,
                'showRemove' => true,
                'showUpload' => true
                ] 
          ]); ?>

    <?= $form->field($model, 'docs[]')
        //->textarea(['rows' => 6]) 
        ->widget(kartik\file\FileInput::className(),[
            'options' => [
                //'accept' => 'image/*',
                'multiple' => true
            ],
            'pluginOptions' => [
                'initialPreview'=>[],
                //'allowedFileExtensions'=>['pdf'],
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => true,
                'overwriteInitial'=>false
            ]
        ]); ?>
        
    
    <div class="row">
        <div class="col-sm-4 col-md-4"> <?= $form->field($model, 'start_date')
                ->textInput()
                /*->widget(kartik\widgets\DatePicker::className(),[
                   'name' => 'dp_1',
                   'type' => kartik\date\DatePicker::TYPE_INPUT,
                   'value' => '',
                   'pluginOptions' => [
                        'language'=>'th-th',
                        'autoclose'=>true,
                        'format' => 'dd-M-yyyy'
                    ] 
                ]);*/
                ?>
        </div>
        <div class="col-sm-4 col-md-4"><?= $form->field($model, 'end_date')
                ->textInput()
                /*->widget(kartik\widgets\DatePicker::className(),[
                   'name' => 'dp_1',
                   'type' => kartik\date\DatePicker::TYPE_INPUT,
                   'value' => '',
                   'pluginOptions' => [
                        'language'=>'th-th',
                        'autoclose'=>true,
                        'format' => 'dd-M-yyyy'
                    ] 
                ]);*/
                ?>
        </div>
        <div class="col-sm-4 col-md-4"><?= $form->field($model, 'success_date')
                ->textInput() 
                /*->widget(kartik\widgets\DatePicker::className(),[
                   'name' => 'dp_1',
                   'type' => kartik\date\DatePicker::TYPE_INPUT,
                   'value' => '',
                   'pluginOptions' => [
                        'language'=>'th-th',
                        'autoclose'=>true,
                        'format' => 'dd-M-yyyy'
                    ] 
                ]);*/
                ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'Create' : 'Update'), ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary').' btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
