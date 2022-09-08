<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kamar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kamar-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'asrama_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Asrama::find()->all(),'id','nama')) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'kapasitas')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
