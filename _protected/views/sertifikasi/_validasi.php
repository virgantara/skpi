<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\SkpiPermohonan */
/* @var $form yii\widgets\ActiveForm */

$list_status_validasi = \app\helpers\MyHelper::getStatusValidasi();

?>

<div class="body">

    <?php $form = ActiveForm::begin([
    	'options' => [
            'id' => 'form_validation',
    	]
    ]); ?>


    <?= $form->field($model, 'status_validasi')->dropDownList($list_status_validasi)?>
    <?= $form->field($model, 'catatan')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'advance',
        'clientOptions' => [
            'enterMode' => 2,
            'forceEnterMode' => false,
            'shiftEnterMode' => 1
        ]
    ]) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary waves-effect']) ?>
    
    <?php ActiveForm::end(); ?>

</div>
