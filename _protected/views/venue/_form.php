<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Venue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venue-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'kapasitas')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
