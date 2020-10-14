<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Organisasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organisasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tingkat')->dropDownList(['1'=>'Lokal','2'=>'Nasional','3'=>'Internasional','4'=>'Dalam Kampus']) ?>

    <?= $form->field($model, 'instansi')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
