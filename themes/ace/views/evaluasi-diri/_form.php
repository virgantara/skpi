<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use dosamigos\fileupload\FileUpload;

/* @var $this yii\web\View */
/* @var $model app\models\EvaluasiDiri */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evaluasi-diri-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'tanggal')->widget(\kartik\date\DatePicker::className(), [
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]) ?>

     <?= $form->field($model, 'strength')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advance'
    ]) ?>

    <?= $form->field($model, 'weakness')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advance'
    ]) ?>

    <?= $form->field($model, 'opportunity')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advance'
    ]) ?>

    <?= $form->field($model, 'threat')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advance'
    ]) ?>
   
    <?= $form->field($model, 'attachment')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
