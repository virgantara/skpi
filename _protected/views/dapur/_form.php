<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dapur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dapur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kampus')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\SimakKampus::find()->all(),'kode_kampus','nama_kampus')) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kapasitas')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
