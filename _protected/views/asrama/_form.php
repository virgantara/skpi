<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Asrama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asrama-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model,['header'=>'<div class="alert alert-danger">','footer'=>'</div>']);?>

    <?= $form->field($model, 'kampus_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\SimakKampus::find()->all(),'id','nama_kampus')) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
