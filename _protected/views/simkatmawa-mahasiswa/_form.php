<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SimkatmawaMahasiswa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="simkatmawa-mahasiswa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'simkatmawa_mandiri_id')->textInput() ?>

    <?= $form->field($model, 'nim')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
